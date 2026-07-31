<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_seats', function (Blueprint $table) {
            $table->id();
            $table->uuid('travel_booking_id');
            $table->foreign('travel_booking_id')->references('id')->on('travel_bookings')->onDelete('cascade');
            $table->integer('seat_number');
            $table->enum('status', ['available', 'booked', 'cancelled'])->default('available');
            $table->uuid('passenger_id')->nullable();
            $table->foreign('passenger_id')->references('id')->on('users')->onDelete('set null');
            $table->string('passenger_name')->nullable();
            $table->string('passenger_phone')->nullable();
            $table->timestamps();
            
            $table->unique(['travel_booking_id', 'seat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_seats');
    }
};
