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
        Schema::rename('photos', 'images');

        Schema::table('images', function (Blueprint $table) {
            $table->string('user_id')->change(); // change to string, rename to follow and must be done separately
            $table->string('post_id')->change(); // change to string, rename to follow and must be done separately
            $table->dropColumn('url');
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('images', function (Blueprint $table) {
            $table->renameColumn('user_id', 'subdirectory');
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('images', function (Blueprint $table) {
            $table->renameColumn('post_id', 'filename');
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('profile_pic_id', 'image_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('image_id')->unsigned()->nullable()->change();
            $table->foreign('image_id')->references('id')->on('images');
        });

        // Split so SQLite via test suite can work since it doesn't support renaming multiple columns at once
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('banner_image_url', 'image_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->bigInteger('image_id')->unsigned()->nullable()->change();
            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only up migrations are allowed
    }
};
