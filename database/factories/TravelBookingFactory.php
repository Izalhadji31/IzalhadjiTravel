<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TravelBookingFactory extends Factory
{
    public function definition(): array
    {
        $seats = fake()->numberBetween(1, 4);
        $total = $seats * 100000;
        $scheduledDate = now()->addDays(fake()->numberBetween(1, 14));

        return [
            'user_id' => User::factory(),
            'route_id' => Route::factory(),
            'booking_code' => 'TRV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
            'passenger_count' => $seats,
            'number_of_seats' => $seats,
            'scheduled_date' => $scheduledDate,
            'total_price' => $total,
            'final_price' => $total,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'departure_time' => $scheduledDate,
        ];
    }
}
