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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['category']);
            $table->string('category')->nullable(true)->change();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('comments_post_id_index');
        });
    }
};
