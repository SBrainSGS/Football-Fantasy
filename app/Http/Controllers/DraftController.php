<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use App\Models\User;
use App\Models\User_Tournament;
use App\Models\Players_Teams;
use App\Models\Players;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DraftController extends Controller
{
    public function startDraft(Request $request)
    {
        // Получаем список пользователей в турнире
        $users = User_Tournament::where('tournament_id', $request['tournament_id'])->get();

        foreach ($users as $user){
            $team = Teams::create([
               'user_id' => $request['user_id'],
            ]);

            $ut = User_Tournament::all()->where('user_id', $request['user_id'], 'tournament_id', $request['tournament_id']);
            $ut -> team_id = $team->id;
        }

        // Получаем список игроков по переданной позиции
        $players = Players::where('position', $request['position'])->get()->toArray();
        shuffle($players);
        $playerIds = array_column($players, 'id');

        // Сохраняем пользователей и игроков в сессии
        Session::put('draft_users', $users->pluck('user_id')->toArray());
        Session::put('draft_players', $playerIds);
        Session::put('current_player_index', 0);

        // Возвращаем первого игрока и порядок выбора
        return response()->json([
            'currentPlayer' => $playerIds[0],
            'draftOrder' => $playerIds,
        ]);
    }

    public function choosePlayer(Request $request)
    {
        $chosenPlayerId = $request['playerId'];

        // Получаем текущего аутентифицированного пользователя
        $user = Auth::user();

        // Получаем информацию о выбранном игроке
        $player = Players::find($chosenPlayerId);
        if (!$player) {
            return response()->json(['error' => 'Player not found'], 404);
        }

        // Проверяем, хватает ли у пользователя денег на покупку игрока
        if ($user->budget < $player->wage) {
            return response()->json(['error' => 'Not enough budget'], 400);
        }

        // Вычитаем стоимость игрока из бюджета пользователя
        $user->budget -= $player->wage;

        Players_Teams::create([
            'team_id' => User_Tournament::where('user_id', $request['user_id'], 'tournament_id', $request['tournament_id'])->pluck('id'),
            'player_id' => $chosenPlayerId,
        ]);


        // Получаем индекс текущего игрока из сессии
        $currentPlayerIndex = Session::get('current_player_index', 0);

        // Обновляем порядок выбора
        $playerIds = Session::get('draft_players', []);
        $playerIds = array_values(array_diff($playerIds, [$chosenPlayerId])); // Удаляем выбранного игрока
        Session::put('draft_players', $playerIds);

        // Увеличиваем индекс текущего игрока для следующего шага
        $currentPlayerIndex++;
        if ($currentPlayerIndex >= count(Session::get('draft_users', []))) {
            $currentPlayerIndex = 0; // Возвращаемся к первому игроку после полного круга
        }
        Session::put('current_player_index', $currentPlayerIndex);

        // Возвращаем информацию о текущем игроке и обновленном порядке выбора
        return response()->json([
            'currentPlayer' => $playerIds[$currentPlayerIndex] ?? null,
            'draftOrder' => $playerIds,
            'budget' => $user->budget,
        ]);
    }
}
