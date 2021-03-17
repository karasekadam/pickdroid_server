<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CountriesForeignNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries_foreign_names', function (Blueprint $table) {
            // imo není potřeba $table->id()->unique();
            $table->string('en_country');
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
        Schema::dropIfExists('countries_foreign_names');
    }
}
