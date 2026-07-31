<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('travel_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('travel_bookings', 'number_of_seats')) {
                $table->integer('number_of_seats')->default(1)->after('passenger_count');
            }

            if (!Schema::hasColumn('travel_bookings', 'scheduled_date')) {
                $table->date('scheduled_date')->nullable()->after('number_of_seats');
            }

            if (!Schema::hasColumn('travel_bookings', 'assigned_armada_id')) {
                $table->foreignId('assigned_armada_id')->nullable()->after('vehicle_id')->constrained('armadas')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('travel_bookings', function (Blueprint $table) {
            foreach (['assigned_armada_id', 'scheduled_date', 'number_of_seats'] as $column) {
                if (Schema::hasColumn('travel_bookings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
