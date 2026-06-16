<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('booking_id');
            $table->uuid('rated_user_id');
            $table->integer('rating'); // 1-5
            $table->text('comment')->nullable();
            $table->enum('review_type', ['cleanliness', 'comfort', 'driver', 'price', 'overall'])->default('overall');
            $table->boolean('is_verified')->default(false);
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('booking_id')->references('id')->on('travel_bookings');
            $table->foreign('rated_user_id')->references('id')->on('users');
            $table->index('user_id');
            $table->index('rated_user_id');
            $table->index('rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
