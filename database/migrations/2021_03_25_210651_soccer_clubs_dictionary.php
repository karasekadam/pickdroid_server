<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SoccerClubsDictionary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // slovník přejmenování týmů z 538
        Schema::create('leagues', function (Blueprint $table) {
            // imo není potřeba $table->id()->unique();
            // zatim neřeším $table->string('sport');
            $table->string('club_name_538')->unique();
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
        Schema::dropIfExists('soccer_clubs_dictionary');
    }
}
