<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('phone');
            $table->string('sim_number')->unique();
            $table->date('sim_expiry');
            $table->string('address');
            $table->string('photo')->nullable();
            $table->enum('status', ['available', 'busy', 'offline', 'on_leave'])->default('offline');
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_trips')->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->foreignId('partner_id')->nullable()->constrained('mitras')->onDelete('set null');
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('partner_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
