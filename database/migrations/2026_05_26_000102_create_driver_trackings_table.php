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
        Schema::create('driver_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained()->cascadeOnDelete();
            $table->string('driver_name');
            $table->string('driver_phone');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('status')->default('available')->comment('available, on_trip, offline, on_break');
            $table->string('current_activity')->nullable()->comment('Current activity description');
            $table->integer('total_trips')->default(0);
            $table->decimal('total_earnings', 15, 2)->default(0);
            $table->decimal('rating', 3, 2)->default(5);
            $table->timestamp('last_online_at')->nullable();
            $table->timestamps();
            
            $table->index('armada_id');
            $table->index('status');
            $table->index('last_online_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_trackings');
    }
};
