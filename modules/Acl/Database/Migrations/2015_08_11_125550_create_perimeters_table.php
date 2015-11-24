<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerimetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perimeters', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('com')->unique();
            $table->string('nom_com');
            $table->string('epci');
            $table->string('nom_epci');
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
        Schema::drop('perimeters');
    }
}
