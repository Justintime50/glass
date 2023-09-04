<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DraftsAndCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Split so SQLite via test suite can work since it doesn't support multiple actions at once when renaming
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('category', 'category_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->integer('published');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Split so SQLite via test suite can work since it doesn't support multiple actions at once when renaming
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('category_id', 'category');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('published');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
