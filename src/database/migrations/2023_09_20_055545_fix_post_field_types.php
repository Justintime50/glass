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
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('category_id')->nullable()->change();
            $table->string('keywords')->nullable()->change();
            $table->mediumText('post')->change();
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
