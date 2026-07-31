<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            // Ende District
            ['name' => 'Ende', 'city' => 'Ende', 'province' => 'NTT', 'latitude' => -8.8333, 'longitude' => 121.6667],
            
            // Mbay
            ['name' => 'Mbay', 'city' => 'Mbay', 'province' => 'NTT', 'latitude' => -8.5, 'longitude' => 121.8333],
            
            // Bajawa
            ['name' => 'Bajawa', 'city' => 'Bajawa', 'province' => 'NTT', 'latitude' => -8.7667, 'longitude' => 120.9167],
            
            // Maumere
            ['name' => 'Maumere', 'city' => 'Maumere', 'province' => 'NTT', 'latitude' => -8.6167, 'longitude' => 122.2167],
            
            // Larantuka
            ['name' => 'Larantuka', 'city' => 'Larantuka', 'province' => 'NTT', 'latitude' => -8.3167, 'longitude' => 123.65],
            
            // Borong
            ['name' => 'Borong', 'city' => 'Borong', 'province' => 'NTT', 'latitude' => -8.45, 'longitude' => 121.3333],
            
            // Ruteng
            ['name' => 'Ruteng', 'city' => 'Ruteng', 'province' => 'NTT', 'latitude' => -8.6333, 'longitude' => 120.5167],
            
            // Labuan Bajo
            ['name' => 'Labuan Bajo', 'city' => 'Labuan Bajo', 'province' => 'NTT', 'latitude' => -8.4167, 'longitude' => 119.4167],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(
                ['city' => $location['city']],
                $location
            );
        }
    }
}
