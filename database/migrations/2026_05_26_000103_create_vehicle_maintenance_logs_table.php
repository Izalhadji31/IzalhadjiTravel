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
        Schema::create('vehicle_maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained()->cascadeOnDelete();
            $table->string('maintenance_type')->comment('Oil change, Tire rotation, Battery, etc');
            $table->text('description')->nullable();
            $table->decimal('cost', 15, 2);
            $table->timestamp('maintenance_date');
            $table->timestamp('scheduled_next_at')->nullable();
            $table->string('status')->default('completed')->comment('completed, scheduled, cancelled');
            $table->string('notes')->nullable();
            $table->timestamps();
            
            $table->index('armada_id');
            $table->index('maintenance_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_maintenance_logs');
    }
};
