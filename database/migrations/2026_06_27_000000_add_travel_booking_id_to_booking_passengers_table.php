<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->uuid('travel_booking_id')->nullable()->after('id');
            $table->string('seat_number')->nullable()->after('nik');
            $table->string('nik')->nullable()->change();
            $table->string('id_number')->nullable()->change();

            $table->foreign('travel_booking_id')->references('id')->on('travel_bookings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('booking_passengers', function (Blueprint $table) {
            $table->dropForeign(['travel_booking_id']);
            $table->dropColumn(['travel_booking_id', 'seat_number']);
        });
    }
};
