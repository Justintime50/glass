<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Photos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('post_id');
            $table->string('url');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('banner_image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('banner_image_url');
        });
    }
}
