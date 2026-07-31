<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->city(),
            'city' => fake()->city(),
            'province' => fake()->state(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'type' => 'city',
            'is_active' => true,
        ];
    }
}
