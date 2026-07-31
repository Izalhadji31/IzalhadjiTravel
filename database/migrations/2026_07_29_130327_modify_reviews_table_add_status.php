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
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('is_verified');
                $table->index('status');
            }
            
            // Make rated_user_id nullable if it's not already
            if (Schema::hasColumn('reviews', 'rated_user_id')) {
                $table->uuid('rated_user_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};