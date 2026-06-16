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
        // Add QR code columns to travel_bookings
        if (Schema::hasTable('travel_bookings') && !Schema::hasColumn('travel_bookings', 'qr_code_token')) {
            Schema::table('travel_bookings', function (Blueprint $table) {
                $table->string('qr_code_token')->nullable()->unique();
                $table->text('qr_code_url')->nullable();
                $table->string('qr_code_path')->nullable();
                $table->enum('qr_code_status', ['active', 'used', 'expired'])->default('active');
                $table->timestamp('qr_code_used_at')->nullable();
                $table->string('checkin_pin')->nullable();
                $table->text('checkin_qr_code')->nullable();
            });
        }

        // Add columns to identity_verifications
        if (Schema::hasTable('identity_verifications') && !Schema::hasColumn('identity_verifications', 'id_expiry_date')) {
            Schema::table('identity_verifications', function (Blueprint $table) {
                $table->date('id_expiry_date')->nullable();
                $table->text('rejection_reason')->nullable();
            });
        }

        // Create notifications table if not exists
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id');
                $table->string('type');
                $table->text('title');
                $table->text('message');
                $table->json('data')->nullable();
                $table->timestamp('read_at')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                $table->index('read_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('travel_bookings', 'qr_code_token')) {
                $table->dropColumn([
                    'qr_code_token',
                    'qr_code_url',
                    'qr_code_path',
                    'qr_code_status',
                    'qr_code_used_at',
                    'checkin_pin',
                    'checkin_qr_code',
                ]);
            }
        });

        Schema::table('identity_verifications', function (Blueprint $table) {
            if (Schema::hasColumn('identity_verifications', 'id_expiry_date')) {
                $table->dropColumn(['id_expiry_date', 'rejection_reason']);
            }
        });

        Schema::dropIfExists('notifications');
    }
};
