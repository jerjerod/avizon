<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvz1TermsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avz_1_terms', function(Blueprint $table)
        {
            $table->increments('id')->index();
            $table->string('name',200);
            $table->string('slug',200);
            $table->string('taxonomy',32);
            $table->text('description')->nullable();
            $table->bigInteger('parent')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('avz_1_terms');
    }

}
