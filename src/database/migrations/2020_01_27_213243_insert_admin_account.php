<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Setting;
use App\Models\Category;

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
        $user = new User();
        $user->id = 1;
        $user->name = 'admin';
        $user->email = 'admin@laraview.com';
        $user->email_verified_at = now();
        $user->password = '$2y$10$P/XLoBoBIkfD6QBxhV5GB.2jXL5OZkc9E2pWAVkm9IKoAUQ0zct52'; // secret
        $user->remember_token = Str::random(10);
        $user->role = 1;
        $user->save();

        // Seed settings table with initial settings
        $setting = new Setting();
        $setting->title = 'Blog';
        $setting->theme = 1;
        $setting->comments = 1;
        $setting->save();

        // Seed an initial category
        $category = new Category();
        $category->user_id = 1;
        $category->category = 'Uncategorized';
        $category->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::truncate();
        Setting::truncate();
        Category::truncate();
    }
}
