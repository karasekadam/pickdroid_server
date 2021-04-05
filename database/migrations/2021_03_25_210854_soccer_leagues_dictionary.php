<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SoccerLeaguesDictionary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // slovník přejmenování lig z 538
        Schema::create('soccer_leagues_dictionary', function (Blueprint $table) {
            // imo není potřeba $table->id()->unique();
            // zatim neřeším $table->string('sport');
            $table->string('league_name_538')->unique();
            $table->integer('538_league_id')->unique();
            $table->string('our_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soccer_leagues_dictionary');
    }
}
