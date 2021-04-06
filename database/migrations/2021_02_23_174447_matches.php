<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Matches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id()->unique();
            $table->integer('season');
            $table->date('date');
            $table->integer("league_id");
            $table->string('league');
            $table->string('team1');
            $table->string('team2');
            $table->float("prob1")->nullable();
            $table->boolean("changable_prob1")->default(true);
            $table->float("prob2")->nullable();
            $table->boolean("changable_prob2")->default(true);
            $table->float("probtie")->nullable();
            $table->boolean("changable_probtie")->default(true);
            $table->integer("priority")->default(10);
            //$table->string("country")->nullable();

            //$table->float("spi1")->nullable();
            //$table->float("spi2")->nullable();
            //$table->float("proj_score1")->nullable();
            //$table->float("proj_score2")->nullable();
            //$table->float("importance1")->nullable();
            //$table->float("importance2")->nullable();
            //$table->integer("score1")->nullable();
            //$table->integer("score2")->nullable();
            //$table->float("xg1")->nullable();
            //$table->float("xg2")->nullable();
            //$table->float("nsxg1")->nullable();
            //$table->float("nsxg2")->nullable();
            //$table->float("adj_score1")->nullable();
            //$table->float("adj_score2")->nullable();
            //$table->integer("priority")->default(10);
            //$table->string("country")->nullable();
            //$table->timestamps();    return after testing
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
