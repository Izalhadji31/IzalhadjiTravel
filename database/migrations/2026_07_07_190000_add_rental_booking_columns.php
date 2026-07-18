<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rental_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('rental_bookings', 'route_id')) {
                $table->uuid('route_id')->nullable()->after('user_id');
                $table->foreign('route_id')->references('id')->on('routes')->nullOnDelete();
            }
            if (!Schema::hasColumn('rental_bookings', 'rental_type')) {
                $table->string('rental_type')->default('without_driver')->after('route_id');
            }
            if (!Schema::hasColumn('rental_bookings', 'with_driver')) {
                $table->boolean('with_driver')->default(false)->after('rental_type');
            }
            if (!Schema::hasColumn('rental_bookings', 'regency_count')) {
                $table->integer('regency_count')->default(1)->after('with_driver');
            }
            if (!Schema::hasColumn('rental_bookings', 'base_price')) {
                $table->decimal('base_price', 10, 2)->default(0)->after('regency_count');
            }
            if (!Schema::hasColumn('rental_bookings', 'driver_fee')) {
                $table->decimal('driver_fee', 10, 2)->default(0)->after('base_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rental_bookings', function (Blueprint $table) {
            $columns = ['route_id', 'rental_type', 'with_driver', 'regency_count', 'base_price', 'driver_fee'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('rental_bookings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
