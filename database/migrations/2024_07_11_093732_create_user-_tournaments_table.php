<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user-_tournaments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('tournament_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('score');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('tournament_id')->references('id')->on('tournaments');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user-_tournaments');
    }
};
