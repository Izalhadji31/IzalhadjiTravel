<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('type', ['email', 'sms', 'whatsapp', 'in_app'])->default('in_app');
            $table->enum('trigger', ['registration', 'booking_created', 'payment_success', 'armada_assigned', 'trip_departure', 'trip_arrival'])->default('booking_created');
            $table->morphs('notifiable'); // Polymorphic - untuk booking atau apapun
            $table->string('title');
            $table->text('message');
            $table->string('send_to')->nullable(); // Email atau nomor WA
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->text('metadata')->nullable(); // JSON
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
