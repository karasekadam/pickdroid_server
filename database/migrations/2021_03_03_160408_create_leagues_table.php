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
            $table->string('sport')->nullable()->default(NULL);
            $table->string('country')->default("Default");
            $table->string('name_538')->nullable()->default(NULL);
            $table->integer('538_league_id')->nullable()->default(NULL);
            $table->string('name_fortuna')->nullable()->default(NULL);
            $table->string('our_name')->nullable()->default(NULL);
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
