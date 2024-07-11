<?php

namespace App\Http\Controllers;

use App\Models\Players;
use Illuminate\Support\Facades\Http;

class PlayersController extends Controller
{
    private $apiKey = 'd7b78e8683d92681b6314df9bd6773eb';

    public function callApi($endpoint, $params = [])
    {
        $url = 'https://v3.football.api-sports.io/' . $endpoint;

        $response = Http::withHeaders([
            'x-rapidapi-key' => $this->apiKey,
        ])->get($url, $params);

        return $response->json();
    }

    public function playersData($league, $season, $page = 1, $playersData = [])
    {
        $players = $this->callApi('players', [
            'league' => $league,
            'season' => $season,
            'page' => $page,
        ]);

        $playersData = array_merge($playersData, $players['response']);

        if ($players['paging']['current'] < $players['paging']['total']) {
            $page = $players['paging']['current'] + 1;
            if ($page % 2 == 1) {
                sleep(1);
            }
            $playersData = $this->playersData($league, $season, $page, $playersData);
        }

        return $playersData;
    }

    public function fetchPlayers()
    {
        $players = $this->playersData(4, 2024);

        foreach ($players as $item) {
            if (is_array($item)) {
                Players::create(
                    ['id' => $item['player']['id'],
                        'name' => $item['player']['name'],
                        'avatar_path' => $item['player']['photo'],
                        'real_team' => $item['statistics'][0]['team']['id'],
                        'position' => $item['statistics'][0]['games']['position'],
                        'wage' => (string)rand(1, 100)
                ]);
            } else {
                return response()->json([
                    'isSuccess' => 'false'
                ]);
            }
        }
        return response()->json(['isSuccess' => 'true']);

//        return response($players);
    }

    public function getAverageWage()
    {
        $averageWage = floor(Players::avg('wage'));

        return response()->json([
            'average_wage' => $averageWage,
        ]);
    }
}
