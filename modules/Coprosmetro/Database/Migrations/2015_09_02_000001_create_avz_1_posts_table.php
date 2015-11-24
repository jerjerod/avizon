<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvz1PostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avz_1_posts', function(Blueprint $table)
        {
            $table->increments('id')->index();
            $table->integer('user_id');
            $table->integer('perimeter_id');
            $table->string('slug',200);
            $table->text('title')->nullable();
            $table->string('excerpt',500)->nullable();
            $table->text('content')->nullable();
            $table->string('status',20)->default('public');
            $table->timestamps();
            $table->softDeletes();
        });
        
        DB::statement("select AddGeometryColumn('','','avz_1_posts','point',4326,'MULTIPOINT',2)");
        DB::statement("CREATE INDEX avz_1_posts_point_index ON avz_1_posts USING gist (point)");
        DB::statement("select AddGeometryColumn('','','avz_1_posts','polygon',4326,'MULTIPOLYGON',2)");
        DB::statement("CREATE INDEX avz_1_posts_polygon_index ON avz_1_posts USING gist (polygon)");
        DB::statement("select AddGeometryColumn('','','avz_1_posts','line',4326,'MULTILINESTRING',2)");
        DB::statement("CREATE INDEX avz_1_posts_line_index ON avz_1_posts USING gist (line)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('avz_1_posts');
    }

}
