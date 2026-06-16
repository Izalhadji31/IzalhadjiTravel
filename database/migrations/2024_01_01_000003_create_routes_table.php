<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('partner_id')->nullable();
            $table->uuid('from_location_id')->nullable();
            $table->uuid('to_location_id')->nullable();
            $table->string('name')->nullable();
            $table->string('origin_city', 100)->nullable();
            $table->string('destination_city', 100)->nullable();
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->decimal('estimated_hours', 5, 2)->nullable();
            $table->enum('route_type', ['travel', 'rental', 'both'])->default('travel');
            $table->enum('service_type', ['travel', 'rental', 'taxi'])->default('travel');
            $table->time('departure_time')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->decimal('price_per_km', 8, 2)->default(5000);
            $table->integer('estimated_distance')->nullable();
            $table->integer('total_seats')->default(4);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('partner_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('from_location_id')->references('id')->on('locations');
            $table->foreign('to_location_id')->references('id')->on('locations');
            $table->index('partner_id');
            $table->index('service_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
