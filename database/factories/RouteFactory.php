<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    public function definition(): array
    {
        $origin = fake()->city();
        $destination = fake()->city();

        return [
            'from_location_id' => Location::factory(),
            'to_location_id' => Location::factory(),
            'name' => "{$origin} - {$destination}",
            'origin_city' => $origin,
            'destination_city' => $destination,
            'distance_km' => fake()->numberBetween(20, 300),
            'estimated_hours' => fake()->randomFloat(1, 1, 8),
            'route_type' => 'both',
            'service_type' => 'travel',
            'base_price' => fake()->numberBetween(50000, 300000),
            'price_per_km' => 5000,
            'estimated_distance' => fake()->numberBetween(20, 300),
            'total_seats' => 4,
            'is_active' => true,
        ];
    }
}
