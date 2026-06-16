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
        Schema::create('rental_prices', function (Blueprint $table) {
            $table->id();
            $table->uuid('route_id');
            $table->foreign('route_id')->references('id')->on('routes')->cascadeOnDelete();
            $table->decimal('price_without_driver', 15, 2);
            $table->decimal('driver_fee_per_regency', 15, 2)->default(100000);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('is_active');
            $table->unique(['route_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_prices');
    }
};
