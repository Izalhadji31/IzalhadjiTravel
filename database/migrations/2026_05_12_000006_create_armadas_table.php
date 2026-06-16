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
        Schema::create('armadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mitra_id')->constrained()->cascadeOnDelete();
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->string('plate_number')->unique();
            $table->string('vehicle_type');
            $table->integer('seat_capacity');
            $table->enum('status', ['tersedia', 'jalan', 'maintenance'])->default('tersedia');
            $table->date('purchase_date')->nullable();
            $table->date('last_maintenance_date')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('mitra_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armadas');
    }
};
