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
        Schema::table('airport_transfer_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('airport_transfer_bookings', 'vehicle_type_id')) {
                $table->uuid('vehicle_type_id')->nullable()->after('transfer_type');
                $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('airport_transfer_bookings', function (Blueprint $table) {
            $table->dropForeign(['vehicle_type_id']);
            $table->dropColumn('vehicle_type_id');
        });
    }
};
