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
        Schema::create('gps_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->unique();
            $table->string('device_name');
            $table->string('device_type')->default('generic');
            $table->foreignId('armada_id')->nullable()->constrained()->nullOnDelete();
            $table->string('api_key')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_contact_at')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->index('armada_id');
            $table->index('is_active');
            $table->index('last_contact_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gps_devices');
    }
};
