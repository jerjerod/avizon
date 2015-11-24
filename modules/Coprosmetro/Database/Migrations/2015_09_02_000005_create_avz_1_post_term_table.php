<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvz1PostTermTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avz_1_post_term', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('post_id')->index();
            $table->foreign('post_id')->references('id')->on('avz_1_posts')->onDelete('cascade');
            $table->integer('term_id')->index();
            $table->foreign('term_id')->references('id')->on('avz_1_terms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('avz_1_post_term');
    }

}
