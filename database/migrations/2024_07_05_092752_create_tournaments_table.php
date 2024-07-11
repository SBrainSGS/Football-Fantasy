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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('host_id')->unsigned();
            $table->smallInteger('max_players')->unsigned();
            $table->integer('max_wage')->unsigned();
            $table->string('link');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->foreign('host_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
