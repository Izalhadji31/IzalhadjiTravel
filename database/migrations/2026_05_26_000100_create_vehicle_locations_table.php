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
        Schema::create('vehicle_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained()->cascadeOnDelete();
            $table->uuid('rental_booking_id')->nullable();
            $table->foreign('rental_booking_id')->references('id')->on('rental_bookings')->nullOnDelete();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('address')->nullable();
            $table->decimal('speed', 8, 2)->default(0)->comment('Speed in km/h');
            $table->decimal('heading', 8, 2)->nullable()->comment('Direction in degrees');
            $table->decimal('accuracy', 8, 2)->nullable()->comment('GPS accuracy in meters');
            $table->string('status')->default('active')->comment('active, idle, offline');
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
            
            $table->index('armada_id');
            $table->index('rental_booking_id');
            $table->index('recorded_at');
            $table->index('status');
            // Note: spatialIndex('location') requires a POINT column named `location`.
            // This migration stores coordinates as `latitude` and `longitude`, so no spatial index is created.

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_locations');
    }
};
