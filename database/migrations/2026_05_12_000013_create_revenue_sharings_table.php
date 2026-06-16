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
        Schema::create('revenue_sharings', function (Blueprint $table) {
            $table->id();
            $table->morphs('booking');
            $table->uuid('payment_id');
            $table->foreign('payment_id')->references('id')->on('payments')->cascadeOnDelete();
            $table->foreignId('mitra_id')->constrained()->restrictOnDelete();
            $table->decimal('admin_amount', 15, 2);
            $table->decimal('mitra_amount', 15, 2);
            $table->decimal('driver_amount', 15, 2);
            $table->decimal('admin_percentage', 5, 2)->default(30);
            $table->decimal('mitra_percentage', 5, 2)->default(50);
            $table->decimal('driver_percentage', 5, 2)->default(20);
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('mitra_id');
            $table->index('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenue_sharings');
    }
};
