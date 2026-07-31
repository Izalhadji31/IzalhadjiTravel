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
        Schema::table('rental_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('rental_bookings', 'voucher_id')) {
                $table->uuid('voucher_id')->nullable()->after('installment_months');
                $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('rental_bookings', 'voucher_id')) {
                $table->dropForeign(['voucher_id']);
                $table->dropColumn('voucher_id');
            }
        });
    }
};
