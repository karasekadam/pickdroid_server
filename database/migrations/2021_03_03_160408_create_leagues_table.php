<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // soubor všech lig používaných 538
        Schema::create('leagues', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('sport');
            $table->string('country');
            $table->string('name_538');
            $table->integer('538_league_id');
            $table->string('name_fortuna');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leagues');
    }
}
