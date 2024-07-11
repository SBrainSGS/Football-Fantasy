<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaguesController;
use App\Http\Controllers\RealTeamsController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\TournamentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/fetchLeagues', [LeaguesController::class, 'fetchLeagues']);

Route::get('/fetchTeams', [RealTeamsController::class, 'fetchTeams']);

Route::get('/fetchPlayers', [PlayersController::class, 'fetchPlayers']);

Route::post('/createTournament', [TournamentController::class, 'store']);

Route::get('/getLeagues', [LeaguesController::class, 'getLeagues']);

Route::get('/getAvgWage', [PlayersController::class, 'getAverageWage']);
