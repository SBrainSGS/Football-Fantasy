<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LeaguesController extends Controller
{
    public function fetchLeagues()
    {
        $response = Http::get('https://fantasy.premierleague.com/api/bootstrap-static/');

        if ($response->successful()) {
            $data = $response->json();
            $leagues = $data['events'];

            foreach ($leagues as $league) {
                if($league['is_current'])
                    League::create(
                        ['id' => $league['id'],
                            'name' => $league['name'],
                            'start_datetime' => $item['seasons'][0]['start'],
                            'end_datetime' => $item['seasons'][0]['end']]
                    );
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
}
