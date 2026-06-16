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
        // Create companies table first (before adding to users)
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('Indonesia');
            $table->string('logo_path')->nullable();
            $table->text('description')->nullable();
            
            // Subscription info
            $table->enum('subscription_plan', ['starter', 'professional', 'enterprise'])->default('starter');
            $table->integer('max_users')->default(10);
            $table->integer('max_vehicles')->default(5);
            $table->boolean('features_tracking')->default(false);
            $table->boolean('features_payment')->default(true);
            $table->boolean('features_analytics')->default(false);
            $table->decimal('monthly_fee', 15, 2)->default(0);
            $table->timestamp('subscription_start_date')->nullable();
            $table->timestamp('subscription_end_date')->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive', 'suspended', 'trial'])->default('trial');
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            
            // Admin reference (will be populated later)
            $table->uuid('admin_user_id')->nullable();
            
            // Audit
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('slug');
            $table->index('status');
            $table->index('subscription_plan');
            $table->index('admin_user_id');
        });

        // Now add company_id to users table immediately
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'company_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop company_id from users first
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'company_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('company_id');
            });
        }

        Schema::dropIfExists('companies');
    }
};
