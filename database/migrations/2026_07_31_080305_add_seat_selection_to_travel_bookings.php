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
        Schema::table('travel_bookings', function (Blueprint $table) {
            $table->json('selected_seats')->nullable()->after('passenger_details');
            $table->json('passenger_data')->nullable()->after('selected_seats');
        });

        // Update booking_passengers table to support travel bookings
        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->uuid('travel_booking_id')->nullable()->after('id');
            $table->foreign('travel_booking_id')->references('id')->on('travel_bookings')->onDelete('cascade');
            $table->string('seat_number')->nullable()->after('id_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->dropForeign(['travel_booking_id']);
            $table->dropColumn('travel_booking_id');
            $table->dropColumn('seat_number');
        });

        Schema::table('travel_bookings', function (Blueprint $table) {
            $table->dropColumn(['selected_seats', 'passenger_data']);
        });
    }
};
