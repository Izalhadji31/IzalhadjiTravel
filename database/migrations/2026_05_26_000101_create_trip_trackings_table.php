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
        Schema::create('trip_trackings', function (Blueprint $table) {
            $table->id();
            $table->uuid('rental_booking_id');
            $table->foreign('rental_booking_id')->references('id')->on('rental_bookings')->cascadeOnDelete();
            $table->foreignId('armada_id')->constrained()->cascadeOnDelete();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->decimal('start_latitude', 10, 8);
            $table->decimal('start_longitude', 11, 8);
            $table->decimal('end_latitude', 10, 8)->nullable();
            $table->decimal('end_longitude', 11, 8)->nullable();
            $table->string('start_address')->nullable();
            $table->string('end_address')->nullable();
            $table->decimal('total_distance', 10, 2)->default(0)->comment('Total distance in km');
            $table->decimal('average_speed', 8, 2)->default(0)->comment('Average speed in km/h');
            $table->integer('duration_minutes')->default(0)->comment('Trip duration in minutes');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->string('status')->default('ongoing')->comment('ongoing, completed, cancelled');
            $table->text('route_polyline')->nullable()->comment('Encoded polyline of trip route');
            $table->timestamps();
            
            $table->index('rental_booking_id');
            $table->index('armada_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('start_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_trackings');
    }
};
