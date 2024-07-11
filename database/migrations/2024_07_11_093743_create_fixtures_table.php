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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('league_id')->unsigned();
            $table->integer('team1')->unsigned();
            $table->integer('team2')->unsigned();
            $table->dateTime('date');
            $table->string('status');
            $table->foreign('league_id')->references('id')->on('leagues');
            $table->foreign('team1')->references('id')->on('teams');
            $table->foreign('team2')->references('id')->on('teams');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
