<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Don't worry about foreign key constraints for tests
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign('posts_image_id_foreign');
                $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only up migrations allowed
    }
};
