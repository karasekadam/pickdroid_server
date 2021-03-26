<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NameRegistr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // netuším, co to dělá
        Schema::create('name_registr', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('sport');
            $table->string('name_538');
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
        Schema::dropIfExists('name_registr');
    }
}
