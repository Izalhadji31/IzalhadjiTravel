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
        Schema::create('airport_transfer_bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('company_id')->nullable();
            $table->string('booking_code')->unique();
            
            // Location Details
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->decimal('pickup_latitude', 10, 8)->nullable();
            $table->decimal('pickup_longitude', 11, 8)->nullable();
            $table->decimal('dropoff_latitude', 10, 8)->nullable();
            $table->decimal('dropoff_longitude', 11, 8)->nullable();
            
            // Booking Details
            $table->dateTime('scheduled_date');
            $table->time('departure_time');
            $table->integer('number_of_passengers')->default(1);
            $table->enum('transfer_type', ['one_way', 'round_trip'])->default('one_way');
            $table->dateTime('return_date')->nullable();
            
            // Vehicle & Driver
            $table->uuid('assigned_armada_id')->nullable();
            $table->uuid('assigned_driver_id')->nullable();
            
            // Pricing
            $table->decimal('base_price', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->uuid('voucher_id')->nullable();
            
            // Status & Notes
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('special_requests')->nullable();
            $table->text('notes')->nullable();
            
            // Tracking
            $table->uuid('trip_tracking_id')->nullable();
            $table->time('actual_pickup_time')->nullable();
            $table->time('actual_dropoff_time')->nullable();
            
            // Additional Info
            $table->string('passenger_name')->nullable();
            $table->string('passenger_phone')->nullable();
            $table->string('flight_number')->nullable();
            $table->string('airline')->nullable();
            $table->dateTime('flight_arrival_time')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('assigned_armada_id')->references('id')->on('armadas')->onDelete('set null');
            $table->foreign('assigned_driver_id')->references('id')->on('drivers')->onDelete('set null');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
            $table->foreign('trip_tracking_id')->references('id')->on('trip_trackings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airport_transfer_bookings');
    }
};
