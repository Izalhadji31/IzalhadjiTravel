<?php

namespace Database\Seeders;

use App\Models\Armada;
use App\Models\Route;
use App\Models\TravelPrice;
use App\Models\RentalPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions
        $this->call(\Database\Seeders\RolePermissionSeeder::class);
        
        // Seed locations
        $this->call(\Database\Seeders\LocationSeeder::class);
        
        // Seed companies
        $this->call(\Database\Seeders\CompanySeeder::class);
        
        // ============================================================
        // SEED ALL USERS — Admin, Mitra, Driver, Customer
        // (Idempotent — aman dijalankan berkali-kali)
        // ============================================================
        $this->call(\Database\Seeders\UserSeeder::class);

        // Seed armadas (tetap pakai DatabaseSeeder untuk FK ke mitra)
        $armadas = [
            [
                'mitra_id' => 1,
                'driver_name' => 'Ahmad',
                'driver_phone' => '081234567893',
                'plate_number' => 'NTT 1001',
                'vehicle_type' => 'Minibus',
                'seat_capacity' => 16,
            ],
            [
                'mitra_id' => 1,
                'driver_name' => 'Budi',
                'driver_phone' => '081234567894',
                'plate_number' => 'NTT 1002',
                'vehicle_type' => 'Minibus',
                'seat_capacity' => 16,
            ],
            [
                'mitra_id' => 2,
                'driver_name' => 'Citra',
                'driver_phone' => '081234567895',
                'plate_number' => 'NTT 2001',
                'vehicle_type' => 'Minibus',
                'seat_capacity' => 16,
            ],
            [
                'mitra_id' => 2,
                'driver_name' => 'Dedi',
                'driver_phone' => '081234567896',
                'plate_number' => 'NTT 2002',
                'vehicle_type' => 'Innova',
                'seat_capacity' => 8,
            ],
        ];

        foreach ($armadas as $armada) {
            $plate = $armada['plate_number'] ?? null;
            if ($plate) {
                Armada::updateOrCreate(
                    ['plate_number' => $plate],
                    $armada
                );
            } else {
                Armada::create($armada);
            }
        }

        // Create routes
        $routes = [
            ['name' => 'Ende - Mbay', 'origin_city' => 'Ende', 'destination_city' => 'Mbay', 'distance_km' => 45, 'estimated_hours' => 1, 'route_type' => 'both'],
            ['name' => 'Ende - Bajawa', 'origin_city' => 'Ende', 'destination_city' => 'Bajawa', 'distance_km' => 90, 'estimated_hours' => 2, 'route_type' => 'both'],
            ['name' => 'Ende - Maumere', 'origin_city' => 'Ende', 'destination_city' => 'Maumere', 'distance_km' => 75, 'estimated_hours' => 2, 'route_type' => 'both'],
            ['name' => 'Ende - Larantuka', 'origin_city' => 'Ende', 'destination_city' => 'Larantuka', 'distance_km' => 120, 'estimated_hours' => 3, 'route_type' => 'both'],
            ['name' => 'Ende - Borong', 'origin_city' => 'Ende', 'destination_city' => 'Borong', 'distance_km' => 105, 'estimated_hours' => 2.5, 'route_type' => 'both'],
            ['name' => 'Ende - Ruteng', 'origin_city' => 'Ende', 'destination_city' => 'Ruteng', 'distance_km' => 130, 'estimated_hours' => 3, 'route_type' => 'both'],
            ['name' => 'Ende - Labuan Bajo', 'origin_city' => 'Ende', 'destination_city' => 'Labuan Bajo', 'distance_km' => 200, 'estimated_hours' => 5, 'route_type' => 'both'],
        ];

        $createdRoutes = [];

        foreach ($routes as $route) {
            $createdRoutes[$route['name']] = Route::updateOrCreate(
                [
                    'origin_city' => $route['origin_city'],
                    'destination_city' => $route['destination_city'],
                    'route_type' => $route['route_type'],
                ],
                [
                    ...$route,
                    'service_type' => 'travel',
                    'base_price' => 0,
                    'estimated_distance' => $route['distance_km'],
                ]
            );
        }

        // Create travel prices
        $travelPrices = [
            ['route' => 'Ende - Mbay', 'price_per_seat' => 100000],
            ['route' => 'Ende - Bajawa', 'price_per_seat' => 150000],
            ['route' => 'Ende - Maumere', 'price_per_seat' => 150000],
            ['route' => 'Ende - Larantuka', 'price_per_seat' => 200000],
            ['route' => 'Ende - Borong', 'price_per_seat' => 175000],
            ['route' => 'Ende - Ruteng', 'price_per_seat' => 200000],
            ['route' => 'Ende - Labuan Bajo', 'price_per_seat' => 250000],
        ];

        foreach ($travelPrices as $price) {
            $route = $createdRoutes[$price['route']] ?? null;
            if (!$route) continue;

            TravelPrice::updateOrCreate(
                ['route_id' => $route->id],
                [
                    'route_id' => $route->id,
                    'price_per_seat' => $price['price_per_seat'],
                    'is_active' => true,
                ]
            );
        }

        // Create rental prices
        $rentalPrices = [
            ['route' => 'Ende - Mbay', 'price_without_driver' => 500000, 'driver_fee_per_regency' => 100000],
            ['route' => 'Ende - Bajawa', 'price_without_driver' => 1000000, 'driver_fee_per_regency' => 100000],
            ['route' => 'Ende - Maumere', 'price_without_driver' => 500000, 'driver_fee_per_regency' => 100000],
            ['route' => 'Ende - Larantuka', 'price_without_driver' => 1000000, 'driver_fee_per_regency' => 100000],
            ['route' => 'Ende - Borong', 'price_without_driver' => 1500000, 'driver_fee_per_regency' => 100000],
            ['route' => 'Ende - Ruteng', 'price_without_driver' => 2000000, 'driver_fee_per_regency' => 100000],
            ['route' => 'Ende - Labuan Bajo', 'price_without_driver' => 2500000, 'driver_fee_per_regency' => 100000],
        ];

        foreach ($rentalPrices as $price) {
            $route = $createdRoutes[$price['route']] ?? null;
            if (!$route) continue;

            RentalPrice::updateOrCreate(
                ['route_id' => $route->id],
                [
                    'route_id' => $route->id,
                    'price_without_driver' => $price['price_without_driver'],
                    'driver_fee_per_regency' => $price['driver_fee_per_regency'],
                    'is_active' => true,
                ]
            );
        }

        // Seed role-specific demo data for Partner and Driver dashboards
        $this->call(\Database\Seeders\DemoRoleDataSeeder::class);

    }
}
