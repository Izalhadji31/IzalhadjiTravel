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
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->text('address');
            $table->string('city');
            $table->string('bank_name');
            $table->string('bank_account')->unique();
            $table->string('bank_holder');
            $table->boolean('is_active')->default(true);
            $table->decimal('revenue_share_percentage', 5, 2)->default(50);
            $table->decimal('total_earnings', 15, 2)->default(0);
            $table->timestamps();
            
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};
