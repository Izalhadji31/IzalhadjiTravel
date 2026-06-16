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
        Schema::create('fleet_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->integer('total_trips')->default(0);
            $table->decimal('total_distance', 10, 2)->default(0);
            $table->integer('total_duration_minutes')->default(0);
            $table->decimal('total_revenue', 15, 2)->default(0);
            $table->decimal('fuel_consumption', 8, 2)->default(0)->comment('Liters');
            $table->decimal('average_speed', 8, 2)->default(0);
            $table->integer('idle_time_minutes')->default(0);
            $table->string('status')->default('active')->comment('active, idle, maintenance');
            $table->timestamps();
            
            $table->unique(['armada_id', 'date']);
            $table->index('date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fleet_analytics');
    }
};
