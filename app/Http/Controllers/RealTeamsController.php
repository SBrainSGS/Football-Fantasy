<?php

namespace App\Http\Controllers;

use App\Models\RealTeams;
use Illuminate\Support\Facades\Http;

class RealTeamsController extends Controller
{
    public function fetchTeams()
    {
        $response = Http::withHeaders([
            'x-rapidapi-key' => 'd081c4dbc435088280995615b881f005',
        ])->get('https://v3.football.api-sports.io/teams', [
            'league' => 4,
            'season' => 2024,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data['response'] as $item) {
                if (is_array($item) && isset($item['team']) && is_array($item['team'])) {
                    RealTeams::create(
                        ['id' => $item['team']['id'],
                            'name' => $item['team']['name'],
                            'logo_path' => $item['team']['logo']]
                    );
                } else {
                    return response()->json([
                        'isSuccess' => 'false'
                    ]);
                }
            }
            return response()->json(['isSuccess' => 'true']);
        } else {
            return response()->json(['error' => 'Failed to fetch teams'], $response->status());
        }
    }
}
