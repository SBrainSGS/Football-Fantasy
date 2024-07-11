<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function store(Request $request)
    {
        $link = $this->generateConnectionCode();

        Tournament::create([
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
}