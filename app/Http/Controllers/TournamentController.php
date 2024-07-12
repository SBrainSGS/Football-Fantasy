<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Players_Teams;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function store(Request $request)
    {
        $link = $this->generateConnectionCode();

        $tournament = Tournament::create([
            'name' => $request['name'],
            'league_id' => $request['league_id'],
            'max_wage' => $request['budget'],
            'start_datetime' => $request['start_datetime'],
            'end_datetime' => $request['end_datetime'],
            'max_players' => $request['max_players'],
            'privacy' => $request['privacy'],
            'host_id' => $request['host_id'],
            'link' => $link
        ]);

        Players_Teams::create([
            'player_id' => $request['host_id'],
            'score' => 0,
            'tournament_id' => $tournament -> id
        ]);

        return response()->json([
           'isSuccess' => 'true',
            'message' => 'Tournament was created successfully',
            'link' => $link
        ]);
    }

    function generateConnectionCode($length = 6) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }

        return $code;
    }

    public function addNewUser(Request $request)
    {

        $link = $request['link'];
        $user = $request['user_id'];
        $id = Tournament::all()->where('link', $link)->pluck('id');


        if (Players_Teams::all()->where('tournament_id', $id)->count() >= Tournament::all()->where('id', $id)->pluck('max_players')){
            return response()->json([
                'isSuccess' => 'false',
                'message' => 'Tournament is full'
            ]);
        }

        Players_Teams::create([
            'player_id' => $user,
            'score' => 0,
            'tournament_id' => $id
        ]);

        return response()->json([
            'isSuccess' => 'true',
            'message' => 'User added successfully'
        ]);
    }
}
