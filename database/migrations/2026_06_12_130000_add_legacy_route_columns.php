<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            if (!Schema::hasColumn('routes', 'name')) {
                $table->string('name')->nullable()->after('to_location_id');
            }

            if (!Schema::hasColumn('routes', 'origin_city')) {
                $table->string('origin_city', 100)->nullable()->after('name');
            }

            if (!Schema::hasColumn('routes', 'destination_city')) {
                $table->string('destination_city', 100)->nullable()->after('origin_city');
            }

            if (!Schema::hasColumn('routes', 'distance_km')) {
                $table->decimal('distance_km', 8, 2)->nullable()->after('destination_city');
            }

            if (!Schema::hasColumn('routes', 'estimated_hours')) {
                $table->decimal('estimated_hours', 5, 2)->nullable()->after('distance_km');
            }

            if (!Schema::hasColumn('routes', 'route_type')) {
                $table->enum('route_type', ['travel', 'rental', 'both'])->default('travel')->after('estimated_hours');
            }
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE routes MODIFY from_location_id CHAR(36) NULL');
            DB::statement('ALTER TABLE routes MODIFY to_location_id CHAR(36) NULL');
            DB::statement('ALTER TABLE routes MODIFY base_price DECIMAL(10, 2) NOT NULL DEFAULT 0');
        }
    }

    public function down(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            foreach (['name', 'origin_city', 'destination_city', 'distance_km', 'estimated_hours', 'route_type'] as $column) {
                if (Schema::hasColumn('routes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
