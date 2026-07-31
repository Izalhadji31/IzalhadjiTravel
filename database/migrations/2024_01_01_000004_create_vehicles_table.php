<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('partner_id');
            $table->string('plate_number')->unique();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->enum('service_type', ['travel', 'rental', 'taxi'])->default('travel');
            $table->integer('total_seats');
            $table->decimal('daily_rate', 10, 2)->nullable();
            $table->string('color')->nullable();
            $table->string('vin')->unique();
            $table->string('registration_number')->unique();
            $table->date('registration_expiry')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->date('tax_expiry')->nullable();
            $table->json('photos')->nullable();
            $table->json('documents')->nullable();
            $table->enum('status', ['active', 'inactive', 'maintenance', 'pending'])->default('pending');
            $table->boolean('is_verified')->default(false);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('partner_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('partner_id');
            $table->index('service_type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
