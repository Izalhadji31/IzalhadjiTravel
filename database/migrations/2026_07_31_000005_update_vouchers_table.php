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
        Schema::table('vouchers', function (Blueprint $table) {
            // Add e-voucher specific fields
            if (!Schema::hasColumn('vouchers', 'booking_id')) {
                $table->uuid('booking_id')->nullable()->after('used_count');
            }
            if (!Schema::hasColumn('vouchers', 'booking_type')) {
                $table->string('booking_type')->nullable()->after('booking_id');
            }
            if (!Schema::hasColumn('vouchers', 'qr_code')) {
                $table->string('qr_code')->nullable()->after('booking_type');
            }
            if (!Schema::hasColumn('vouchers', 'used_at')) {
                $table->timestamp('used_at')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('vouchers', 'voucher_type')) {
                $table->string('voucher_type')->default('discount')->after('type'); // discount, e-voucher
            }
            if (!Schema::hasColumn('vouchers', 'metadata')) {
                $table->json('metadata')->nullable()->after('used_at');
            }
        });
        
        // Add index separately
        Schema::table('vouchers', function (Blueprint $table) {
            if (!Schema::hasColumn('vouchers', 'booking_id')) {
                return; // Skip if column wasn't added
            }
            try {
                $table->index(['booking_id', 'booking_type']);
            } catch (\Exception $e) {
                // Index might already exist, ignore
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            try {
                $table->dropIndex(['booking_id', 'booking_type']);
            } catch (\Exception $e) {
                // Index might not exist
            }
            $table->dropColumn([
                'booking_id',
                'booking_type',
                'qr_code',
                'used_at',
                'voucher_type',
                'metadata'
            ]);
        });
    }
};
