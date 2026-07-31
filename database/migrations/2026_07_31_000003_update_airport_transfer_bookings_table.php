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
            // Add city field (default to Ende)
            if (!Schema::hasColumn('airport_transfer_bookings', 'city')) {
                $table->string('city')->default('Ende')->after('company_id');
            }

            // Add pickup/dropoff address fields
            if (!Schema::hasColumn('airport_transfer_bookings', 'pickup_address')) {
                $table->text('pickup_address')->nullable()->after('pickup_location');
            }
            if (!Schema::hasColumn('airport_transfer_bookings', 'dropoff_address')) {
                $table->text('dropoff_address')->nullable()->after('dropoff_location');
            }

            // Add pickup/dropoff type (airport/hotel/address/etc)
            if (!Schema::hasColumn('airport_transfer_bookings', 'pickup_type')) {
                $table->string('pickup_type')->nullable()->after('pickup_address');
            }
            if (!Schema::hasColumn('airport_transfer_bookings', 'dropoff_type')) {
                $table->string('dropoff_type')->nullable()->after('dropoff_address');
            }

            // Add index for city
            if (!Schema::hasIndex('airport_transfer_bookings', 'airport_transfer_bookings_city_index')) {
                $table->index('city');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('airport_transfer_bookings', function (Blueprint $table) {
            $table->dropIndex(['city']);
            $table->dropColumn([
                'city',
                'pickup_address',
                'dropoff_address',
                'pickup_type',
                'dropoff_type',
            ]);
        });
    }
};
