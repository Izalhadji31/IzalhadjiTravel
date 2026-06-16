<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Route;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        // Get locations
        $ende = Location::where('city', 'Ende')->first();
        
        $routes = [
            ['from' => 'Ende', 'to' => 'Mbay', 'price' => 100000, 'distance' => 50],
            ['from' => 'Ende', 'to' => 'Bajawa', 'price' => 150000, 'distance' => 100],
            ['from' => 'Ende', 'to' => 'Maumere', 'price' => 150000, 'distance' => 120],
            ['from' => 'Ende', 'to' => 'Larantuka', 'price' => 200000, 'distance' => 180],
            ['from' => 'Ende', 'to' => 'Borong', 'price' => 175000, 'distance' => 90],
            ['from' => 'Ende', 'to' => 'Ruteng', 'price' => 200000, 'distance' => 140],
            ['from' => 'Ende', 'to' => 'Labuan Bajo', 'price' => 250000, 'distance' => 280],
        ];

        foreach ($routes as $routeData) {
            $fromLocation = Location::where('city', $routeData['from'])->first();
            $toLocation = Location::where('city', $routeData['to'])->first();

            if ($fromLocation && $toLocation) {
                Route::updateOrCreate(
                    [
                        'from_location_id' => $fromLocation->id,
                        'to_location_id' => $toLocation->id,
                    ],
                    [
                        'id' => Str::uuid(),
                        'name' => "{$routeData['from']} - {$routeData['to']}",
                        'origin_city' => $routeData['from'],
                        'destination_city' => $routeData['to'],
                        'distance_km' => $routeData['distance'],
                        'estimated_hours' => max(1, round($routeData['distance'] / 45, 1)),
                        'route_type' => 'both',
                        'service_type' => 'travel',
                        'base_price' => $routeData['price'],
                        'estimated_distance' => $routeData['distance'],
                        'total_seats' => 4,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
