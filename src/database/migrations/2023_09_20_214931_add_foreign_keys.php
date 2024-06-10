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
        Schema::table('comments', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->bigInteger('post_id')->unsigned()->change();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('post_id')->references('id')->on('posts');

            $table->renameIndex('comments_post_id_index', 'comments_post_id_foreign');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->bigInteger('category_id')->unsigned()->nullable()->change();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->renameIndex('posts_category_id_index', 'posts_category_id_foreign');
            $table->renameIndex('posts_user_id_index', 'posts_user_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comments_user_id_foreign');
            $table->dropForeign('comments_post_id_foreign');

            $table->dropIndex('comments_user_id_foreign');
            $table->renameIndex('comments_post_id_foreign', 'comments_post_id_index');
        });

        // Changes must be done separately from dropping indexes
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('user_id')->change();
            $table->integer('post_id')->change();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('posts_user_id_foreign');
            $table->dropForeign('posts_category_id_foreign');

            $table->renameIndex('posts_category_id_foreign', 'posts_category_id_index');
            $table->renameIndex('posts_user_id_foreign', 'posts_user_id_index');
        });

        // Changes must be done separately from dropping indexes
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('user_id')->change();
            $table->integer('category_id')->nullable()->change();
        });
    }
};
