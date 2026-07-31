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
        Schema::create('rental_booking_addon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_booking_id')->constrained('rental_bookings')->onDelete('cascade');
            $table->foreignId('addon_id')->constrained('addons')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price_at_booking', 10, 2)->default(0);
            $table->timestamps();
            
            $table->unique(['rental_booking_id', 'addon_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_booking_addon');
    }
};
