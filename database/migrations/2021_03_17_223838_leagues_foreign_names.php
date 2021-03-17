<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeaguesForeignNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leagues_foreign_names', function (Blueprint $table) {
            // imo není potřeba $table->id()->unique();
            $table->integer("league_id");
            $table->string('538_league_names');
            $table->string('foreign_name');
            $table->string('foreign_country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leagues_foreign_names');
    }
}
