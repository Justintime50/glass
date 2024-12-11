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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('category')->nullable(false)->change();
            $table->unique('category');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->index(['post_id']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->index(['category_id']);
            $table->index(['user_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index(['name']);
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
