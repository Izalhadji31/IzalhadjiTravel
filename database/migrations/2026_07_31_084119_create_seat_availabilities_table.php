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
        Schema::create('seat_availabilities', function (Blueprint $table) {
            $table->id();
            $table->uuid('route_id');
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
            $table->date('travel_date');
            $table->uuid('armada_id')->nullable();
            $table->foreign('armada_id')->references('id')->on('armadas')->onDelete('set null');
            $table->integer('seat_number');
            $table->enum('status', ['available', 'booked', 'locked'])->default('available');
            $table->uuid('locked_by')->nullable();
            $table->foreign('locked_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamp('locked_until')->nullable();
            $table->uuid('travel_booking_id')->nullable();
            $table->foreign('travel_booking_id')->references('id')->on('travel_bookings')->onDelete('set null');
            $table->timestamps();
            
            // Unique constraint to prevent duplicate seat records
            $table->unique(['route_id', 'travel_date', 'armada_id', 'seat_number']);
            
            // Indexes for common queries
            $table->index(['route_id', 'travel_date', 'status']);
            $table->index(['travel_date', 'status']);
            $table->index(['locked_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat_availabilities');
    }
};
