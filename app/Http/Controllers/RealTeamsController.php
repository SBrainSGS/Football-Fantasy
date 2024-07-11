<?php

namespace App\Http\Controllers;

use App\Models\RealTeams;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class RealTeamsController extends Controller
{
    /*public function fetchTeams()
    {
        // Get the current date and the date one month from now
        $currentDate = Carbon::now();
        $endDate = Carbon::now()->addMonth();

        // Fetch fixtures data
        $response = Http::withHeaders(
            ['cookie' => 'OptanonAlertBoxClosed=2024-07-11T20:58:50.421Z; fdp-session=a2c1f1af-a9bc-44ea-a70f-0a7318157647; fdp-fingerprint=448adbc0a7eb7a734ca852910412ac1d; pl_profile="eyJzIjogIld6RXNPREl6T0RVd01EUmQ6MXNTMVFNOkxLa0dwLW9PM1ZaOEUwd1oyYXRNeXF2QXZkNWZTaVlwTXBiU3NPeVhPcWciLCAidSI6IHsiaWQiOiA4MjM4NTAwNCwgImZuIjogIkF6aXoiLCAibG4iOiAiU2FsaW1vdiIsICJmYyI6IDkxfX0="; OptanonConsent=isGpcEnabled=0&datestamp=Fri+Jul+12+2024+00%3A52%3A45+GMT%2B0300+(%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C+%D1%81%D1%82%D0%B0%D0%BD%D0%B4%D0%B0%D1%80%D1%82%D0%BD%D0%BE%D0%B5+%D0%B2%D1%80%D0%B5%D0%BC%D1%8F)&version=202302.1.0&isIABGlobal=false&hosts=&landingPath=NotLandingPage&groups=C0003%3A0%2CC0004%3A0%2CC0002%3A0%2CC0001%3A1&AwaitingReconsent=false&geolocation=NL%3BNH; csrftoken=FOtlPkTMsnKx2T9NKSgEjJ4b3Bpc3cnZ; sessionid=.eJxVzLEKAjEQBNB_SS1Hkt3EnJ29oHBYh91sjoiHHMarxH836bScecy8VaTtVeJW8zPeRB1UsBCc1qh2v8SU7vnRfV3mdRm6DJfTtVmdpvOxxf9BoVr6G4O2QbIXELbeJgLYB8PGI-jsYKQEnjNYFmHEVgnNDnnEoMEIqc8X9cIzEQ:1sS1ia:BaQ8gf_rybsvevGRGIRSuWN4jeJg8CEMkQaoKqReaEg; datadome=gnStAFfln7bd085IuvoGhXp_ZGqnlX2YBdYufBqChnfPp00qdlB2qnCamJnQ_i78NLX3pVzvqsrIGPMl~umEoiU2vngNW~z_ynJofqRgn6CaM4iK8sQqrsetvbPMhmAv',
                ])->get('https://fantasy.premierleague.com/api/fixtures/');

        if ($response->successful()) {
            $fixtures = $response->json();

            $teamIds = [];

            // Filter fixtures that are within the next month
            foreach ($fixtures as $fixture) {
                $fixtureDate = Carbon::parse($fixture['kickoff_time']);

                if ($fixtureDate->between($currentDate, $endDate)) {
                    // Collect team ids from the filtered fixtures
                    $teamIds[] = $fixture['team_h'];
                    $teamIds[] = $fixture['team_a'];
                }
            }
            // Remove duplicate team ids
            $teamIds = array_unique($teamIds);

            // Fetch team data
            $response = Http::withHeaders(
                ['cookie' => 'OptanonAlertBoxClosed=2024-07-11T20:58:50.421Z; fdp-session=a2c1f1af-a9bc-44ea-a70f-0a7318157647; fdp-fingerprint=448adbc0a7eb7a734ca852910412ac1d; pl_profile="eyJzIjogIld6RXNPREl6T0RVd01EUmQ6MXNTMVFNOkxLa0dwLW9PM1ZaOEUwd1oyYXRNeXF2QXZkNWZTaVlwTXBiU3NPeVhPcWciLCAidSI6IHsiaWQiOiA4MjM4NTAwNCwgImZuIjogIkF6aXoiLCAibG4iOiAiU2FsaW1vdiIsICJmYyI6IDkxfX0="; OptanonConsent=isGpcEnabled=0&datestamp=Fri+Jul+12+2024+00%3A52%3A45+GMT%2B0300+(%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C+%D1%81%D1%82%D0%B0%D0%BD%D0%B4%D0%B0%D1%80%D1%82%D0%BD%D0%BE%D0%B5+%D0%B2%D1%80%D0%B5%D0%BC%D1%8F)&version=202302.1.0&isIABGlobal=false&hosts=&landingPath=NotLandingPage&groups=C0003%3A0%2CC0004%3A0%2CC0002%3A0%2CC0001%3A1&AwaitingReconsent=false&geolocation=NL%3BNH; csrftoken=FOtlPkTMsnKx2T9NKSgEjJ4b3Bpc3cnZ; sessionid=.eJxVzLEKAjEQBNB_SS1Hkt3EnJ29oHBYh91sjoiHHMarxH836bScecy8VaTtVeJW8zPeRB1UsBCc1qh2v8SU7vnRfV3mdRm6DJfTtVmdpvOxxf9BoVr6G4O2QbIXELbeJgLYB8PGI-jsYKQEnjNYFmHEVgnNDnnEoMEIqc8X9cIzEQ:1sS1ia:BaQ8gf_rybsvevGRGIRSuWN4jeJg8CEMkQaoKqReaEg; datadome=gnStAFfln7bd085IuvoGhXp_ZGqnlX2YBdYufBqChnfPp00qdlB2qnCamJnQ_i78NLX3pVzvqsrIGPMl~umEoiU2vngNW~z_ynJofqRgn6CaM4iK8sQqrsetvbPMhmAv',
                ])->get('https://fantasy.premierleague.com/api/bootstrap-static/');

            if ($response->successful()) {
                $data = $response->json();
                $teams = $data['teams'];

                $upcomingTeams = array_filter($teams, function($team) use ($teamIds) {
                    return in_array($team['id'], $teamIds);
                });

                foreach ($upcomingTeams as $team) {
                    RealTeams::create(
                        ['id' => $team['id'],
                            'name' => $team['name'],
                            'logo_path' => 'test']
                    );
                    return response()->json($team);
                }

                return response($teamIds);

                return response()->json([
                    'isSuccess' => 'true',
                    'message' => 'Teams fetched successfully'
                ]);
            } else {
                return response()->json([
                    'isSuccess' => 'false',
                    'message' => 'Failed to fetch teams data'
                ]);
            }
        } else {
            return response()->json([
                'isSuccess' => 'false',
                'message' => 'Failed to fetch teams data'
            ]);
        }
    }*/
    public function fetchTeams()
    {
        $response = Http::withHeaders([
            'x-rapidapi-key' => 'd7b78e8683d92681b6314df9bd6773eb',
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
