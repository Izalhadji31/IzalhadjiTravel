<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Payments are polymorphic, so booking_id must not be constrained to travel bookings only.
            $table->dropForeign(['booking_id']);
            $table->string('payment_method')->default('midtrans')->change();
            $table->string('status')->default('pending')->change();

            if (!Schema::hasColumn('payments', 'midtrans_reference')) {
                $table->string('midtrans_reference')->nullable()->index();
            }

            if (!Schema::hasColumn('payments', 'midtrans_transaction_id')) {
                $table->string('midtrans_transaction_id')->nullable();
            }
        });
    }

    public function down(): void
    {
        // This migration may run against installations that already had the
        // Midtrans columns. Dropping them on rollback could destroy data.
    }
};
