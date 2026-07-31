<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleTypes = [
            [
                'id' => Str::uuid(),
                'name' => 'Sedan',
                'slug' => 'sedan',
                'capacity' => 4,
                'base_price_multiplier' => 1.0,
                'icon' => '🚗',
                'description' => 'Comfortable sedan for up to 4 passengers',
                'image_url' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'SUV',
                'slug' => 'suv',
                'capacity' => 6,
                'base_price_multiplier' => 1.3,
                'icon' => '🚙',
                'description' => 'Spacious SUV for up to 6 passengers',
                'image_url' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'MPV',
                'slug' => 'mpv',
                'capacity' => 7,
                'base_price_multiplier' => 1.4,
                'icon' => '🚐',
                'description' => 'Multi-purpose vehicle for up to 7 passengers',
                'image_url' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Van',
                'slug' => 'van',
                'capacity' => 10,
                'base_price_multiplier' => 1.8,
                'icon' => '🚐',
                'description' => 'Large van for up to 10 passengers',
                'image_url' => null,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Luxury',
                'slug' => 'luxury',
                'capacity' => 4,
                'base_price_multiplier' => 2.5,
                'icon' => '🏎️',
                'description' => 'Premium luxury vehicle for up to 4 passengers',
                'image_url' => null,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Minibus',
                'slug' => 'minibus',
                'capacity' => 14,
                'base_price_multiplier' => 2.0,
                'icon' => '🚌',
                'description' => 'Minibus for up to 14 passengers',
                'image_url' => null,
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        DB::table('vehicle_types')->insert($vehicleTypes);
    }
}
