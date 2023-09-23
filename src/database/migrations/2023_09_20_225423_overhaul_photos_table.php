<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->string('user_id')->change(); // change to string, rename to follow
            $table->string('post_id')->change(); // change to string, rename to follow
            $table->dropColumn('url');
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('photos', function (Blueprint $table) {
            $table->renameColumn('user_id', 'subdirectory');
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('photos', function (Blueprint $table) {
            $table->renameColumn('post_id', 'filename');
        });

        Schema::rename('photos', 'images');

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('profile_pic_id', 'image_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('image_id')->unsigned()->change();
            $table->foreign('image_id')->references('id')->on('images');
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('banner_image_url', 'image_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->bigInteger('image_id')->unsigned()->change();
            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->integer('subdirectory')->change();
            $table->integer('filename')->change();
            $table->string('url');
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('images', function (Blueprint $table) {
            $table->renameColumn('subdirectory', 'user_id');
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('images', function (Blueprint $table) {
            $table->renameColumn('filename', 'post_id');
        });

        Schema::rename('images', 'photos');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_image_id_foreign');
            $table->dropIndex('users_image_id_foreign');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('image_id')->change();
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('image_id', 'profile_pic_id');
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('image_id', 'banner_image_url');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('posts_image_id_foreign');
            $table->dropIndex('posts_image_id_foreign');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('banner_image_url')->change();
        });
    }
};
