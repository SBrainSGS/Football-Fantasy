<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LeaguesController extends Controller
{
    public function fetchLeagues()
    {
        $response = Http::withHeaders(
            [
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => 'd7b78e8683d92681b6314df9bd6773eb'
            ]
        )->get('https://v3.football.api-sports.io/leagues', [
            'season' => date('Y')
        ]);

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data['response'] as $item) {
                if (is_array($item) && isset($item['league']) && is_array($item['league'])) {
                    League::create(
                        ['id' => $item['league']['id'],
                            'name' => $item['league']['name'],
                            'start_datetime' => $item['seasons'][0]['start'],
                            'end_datetime' => $item['seasons'][0]['end']]
                    );
                }
            }

//            return $response;

            return response()->json([
               'isSuccess' => 'true'
            ]);
        } else {
            return response()->json([
                'isSuccess' => 'false'
            ]);
        }
    }

    public function getLeagues()
    {
        $leagues = League::all();
        return response()->json([
            'leagues' => $leagues,
        ]);
    }
}
