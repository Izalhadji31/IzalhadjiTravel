<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add company_id to all existing tables for multi-tenant support
     */
    public function up(): void
    {
        // Users already has company_id from companies migration
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'company_id') && !Schema::hasTable('companies')) {
            return; // Skip if companies not created yet
        }

        // Add foreign key to users table
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'company_id')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'company_id')) {
                    $table->uuid('company_id')->nullable()->after('id');
                }
                // Check if foreign key doesn't exist before adding
                try {
                    $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                } catch (\Exception $e) {
                    // Foreign key might already exist
                }
                $table->index('company_id');
            });
        }

        // Routes table
        if (Schema::hasTable('routes') && !Schema::hasColumn('routes', 'company_id')) {
            Schema::table('routes', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Travel Bookings table
        if (Schema::hasTable('travel_bookings') && !Schema::hasColumn('travel_bookings', 'company_id')) {
            Schema::table('travel_bookings', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Rental Bookings table
        if (Schema::hasTable('rental_bookings') && !Schema::hasColumn('rental_bookings', 'company_id')) {
            Schema::table('rental_bookings', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Payments table
        if (Schema::hasTable('payments') && !Schema::hasColumn('payments', 'company_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Revenue Sharings table
        if (Schema::hasTable('revenue_sharings') && !Schema::hasColumn('revenue_sharings', 'company_id')) {
            Schema::table('revenue_sharings', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Audit Logs table
        if (Schema::hasTable('audit_logs') && !Schema::hasColumn('audit_logs', 'company_id')) {
            Schema::table('audit_logs', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Vehicles table
        if (Schema::hasTable('vehicles') && !Schema::hasColumn('vehicles', 'company_id')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Vehicle Locations table
        if (Schema::hasTable('vehicle_locations') && !Schema::hasColumn('vehicle_locations', 'company_id')) {
            Schema::table('vehicle_locations', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Trip Trackings table
        if (Schema::hasTable('trip_trackings') && !Schema::hasColumn('trip_trackings', 'company_id')) {
            Schema::table('trip_trackings', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Driver Trackings table
        if (Schema::hasTable('driver_trackings') && !Schema::hasColumn('driver_trackings', 'company_id')) {
            Schema::table('driver_trackings', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Fleet Analytics table
        if (Schema::hasTable('fleet_analytics') && !Schema::hasColumn('fleet_analytics', 'company_id')) {
            Schema::table('fleet_analytics', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Invoices table
        if (Schema::hasTable('invoices') && !Schema::hasColumn('invoices', 'company_id')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }

        // Identity Verifications table
        if (Schema::hasTable('identity_verifications') && !Schema::hasColumn('identity_verifications', 'company_id')) {
            Schema::table('identity_verifications', function (Blueprint $table) {
                $table->uuid('company_id')->nullable()->after('id');
                $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                $table->index('company_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users', 'routes', 'travel_bookings', 'rental_bookings', 'payments',
            'revenue_sharings', 'audit_logs', 'vehicles', 'vehicle_locations',
            'trip_trackings', 'driver_trackings', 'fleet_analytics', 'invoices',
            'identity_verifications'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'company_id')) {
                Schema::table($table, function (Blueprint $table) {
                    try {
                        $table->dropForeignKeyIfExists([$table->getForeignKeyName('company_id')]);
                    } catch (\Exception $e) {
                        // Foreign key doesn't exist
                    }
                    try {
                        $table->dropIndex("{$table}_company_id_index");
                    } catch (\Exception $e) {
                        // Index doesn't exist
                    }
                    $table->dropColumn('company_id');
                });
            }
        }
    }
};
