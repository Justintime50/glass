<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertAdminAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Seed User's table with initial account
        DB::table('users')->insert([
            'name' => "admin",
            'email' => "admin@laraview.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$P/XLoBoBIkfD6QBxhV5GB.2jXL5OZkc9E2pWAVkm9IKoAUQ0zct52', // password = "password"
            'remember_token' => Str::random(10),
            'role' => 1,
        ]);

        // Seed settings table with initial settings
        DB::table('settings')->insert([
            'title' => "Blog",
            'theme' => 1,
            'comments' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // TODO: Add in a way to delete this
    }
}
