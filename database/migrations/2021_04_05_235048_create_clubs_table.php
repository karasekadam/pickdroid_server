<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // tabulka klubů i s našimi jmény a v jaké lize se nacházejí
        Schema::create('clubs', function (Blueprint $table) {
            $table->id()->unique();
            $table->string("538_name")->nullable()->default(NULL);
            $table->string("our_name")->nullable()->default(NULL);
            $table->string("league"); // linkuje na jméno ligy z 538, chtělo by to udělat na ligu
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clubs');
    }
}
