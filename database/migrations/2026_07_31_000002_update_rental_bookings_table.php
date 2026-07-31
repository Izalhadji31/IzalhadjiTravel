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
            // Replace route-based with city-based
            if (!Schema::hasColumn('rental_bookings', 'pickup_city')) {
                $table->string('pickup_city')->nullable()->after('route_id');
            }
            if (!Schema::hasColumn('rental_bookings', 'dropoff_city')) {
                $table->string('dropoff_city')->nullable()->after('pickup_city');
            }

            // Add time selection
            if (!Schema::hasColumn('rental_bookings', 'start_time')) {
                $table->time('start_time')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('rental_bookings', 'end_time')) {
                $table->time('end_time')->nullable()->after('end_date');
            }

            // Add pickup/drop-off locations (rename existing if needed)
            if (Schema::hasColumn('rental_bookings', 'return_location') && !Schema::hasColumn('rental_bookings', 'dropoff_location')) {
                $table->renameColumn('return_location', 'dropoff_location');
            }
            if (!Schema::hasColumn('rental_bookings', 'pickup_location')) {
                $table->string('pickup_location')->nullable()->after('end_time');
            }
            // dropoff_location might already exist from rename or previous migration
            if (!Schema::hasColumn('rental_bookings', 'dropoff_location')) {
                $table->string('dropoff_location')->nullable()->after('pickup_location');
            }

            // Add addresses
            if (!Schema::hasColumn('rental_bookings', 'pickup_address')) {
                $table->text('pickup_address')->nullable()->after('dropoff_location');
            }
            if (!Schema::hasColumn('rental_bookings', 'dropoff_address')) {
                $table->text('dropoff_address')->nullable()->after('pickup_address');
            }

            // Add geolocation
            if (!Schema::hasColumn('rental_bookings', 'pickup_lat')) {
                $table->decimal('pickup_lat', 10, 8)->nullable()->after('dropoff_address');
            }
            if (!Schema::hasColumn('rental_bookings', 'pickup_lng')) {
                $table->decimal('pickup_lng', 11, 8)->nullable()->after('pickup_lat');
            }
            if (!Schema::hasColumn('rental_bookings', 'dropoff_lat')) {
                $table->decimal('dropoff_lat', 10, 8)->nullable()->after('pickup_lng');
            }
            if (!Schema::hasColumn('rental_bookings', 'dropoff_lng')) {
                $table->decimal('dropoff_lng', 11, 8)->nullable()->after('dropoff_lat');
            }

            // Add vehicle type
            if (!Schema::hasColumn('rental_bookings', 'vehicle_type_id')) {
                $table->uuid('vehicle_type_id')->nullable()->after('dropoff_lng');
                $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('set null');
            }

            // Add rental_type enum if not exists
            if (!Schema::hasColumn('rental_bookings', 'rental_type')) {
                $table->enum('rental_type', ['with_driver', 'without_driver'])->default('with_driver')->after('vehicle_type_id');
            }

            // Add special requests
            if (!Schema::hasColumn('rental_bookings', 'special_requests')) {
                $table->text('special_requests')->nullable()->after('total_price');
            }

            // Add guest booking support
            if (!Schema::hasColumn('rental_bookings', 'is_for_guest')) {
                $table->boolean('is_for_guest')->default(false)->after('special_requests');
            }
            if (!Schema::hasColumn('rental_bookings', 'guest_name')) {
                $table->string('guest_name')->nullable()->after('is_for_guest');
            }
            if (!Schema::hasColumn('rental_bookings', 'guest_phone')) {
                $table->string('guest_phone')->nullable()->after('guest_name');
            }
            if (!Schema::hasColumn('rental_bookings', 'guest_email')) {
                $table->string('guest_email')->nullable()->after('guest_phone');
            }

            // Add voucher system
            if (!Schema::hasColumn('rental_bookings', 'voucher_code')) {
                $table->string('voucher_code')->nullable()->unique()->after('guest_email');
            }

            // Add installment support
            if (!Schema::hasColumn('rental_bookings', 'installment_months')) {
                $table->integer('installment_months')->nullable()->after('voucher_code');
            }

            // Add pickup instructions
            if (!Schema::hasColumn('rental_bookings', 'pickup_instructions')) {
                $table->text('pickup_instructions')->nullable()->after('installment_months');
            }

            // Add driver assignment info
            if (!Schema::hasColumn('rental_bookings', 'driver_name')) {
                $table->string('driver_name')->nullable()->after('pickup_instructions');
            }
            if (!Schema::hasColumn('rental_bookings', 'driver_phone')) {
                $table->string('driver_phone')->nullable()->after('driver_name');
            }

            // Add estimated distance
            if (!Schema::hasColumn('rental_bookings', 'estimated_distance_km')) {
                $table->integer('estimated_distance_km')->nullable()->after('driver_phone');
            }

            // Indexes
            if (!Schema::hasIndex('rental_bookings', 'rental_bookings_pickup_city_index')) {
                $table->index('pickup_city');
            }
            if (!Schema::hasIndex('rental_bookings', 'rental_bookings_dropoff_city_index')) {
                $table->index('dropoff_city');
            }
            if (!Schema::hasIndex('rental_bookings', 'rental_bookings_vehicle_type_id_index')) {
                $table->index('vehicle_type_id');
            }
            if (!Schema::hasIndex('rental_bookings', 'rental_bookings_voucher_code_index')) {
                $table->index('voucher_code');
            }
            if (!Schema::hasIndex('rental_bookings', 'rental_bookings_start_date_index')) {
                $table->index('start_date');
            }
            if (!Schema::hasIndex('rental_bookings', 'rental_bookings_end_date_index')) {
                $table->index('end_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_bookings', function (Blueprint $table) {
            $table->dropForeign(['vehicle_type_id']);
            $table->dropIndex(['vehicle_type_id']);
            $table->dropIndex(['pickup_city']);
            $table->dropIndex(['dropoff_city']);
            $table->dropIndex(['voucher_code']);
            $table->dropIndex(['start_date']);
            $table->dropIndex(['end_date']);

            $table->dropColumn([
                'pickup_city',
                'dropoff_city',
                'start_time',
                'end_time',
                'pickup_location',
                'dropoff_location',
                'pickup_address',
                'dropoff_address',
                'pickup_lat',
                'pickup_lng',
                'dropoff_lat',
                'dropoff_lng',
                'vehicle_type_id',
                'rental_type',
                'special_requests',
                'is_for_guest',
                'guest_name',
                'guest_phone',
                'guest_email',
                'voucher_code',
                'installment_months',
                'pickup_instructions',
                'driver_name',
                'driver_phone',
                'estimated_distance_km',
            ]);
        });
    }
};
