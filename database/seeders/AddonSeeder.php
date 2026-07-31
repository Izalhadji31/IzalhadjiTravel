<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\AddonCategory;
use Illuminate\Database\Seeder;

class AddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $safetyCategory = AddonCategory::where('slug', 'safety')->first();
        $comfortCategory = AddonCategory::where('slug', 'comfort')->first();
        $techCategory = AddonCategory::where('slug', 'technology')->first();
        $luggageCategory = AddonCategory::where('slug', 'luggage')->first();

        $addons = [
            // Safety
            [
                'category_id' => $safetyCategory->id,
                'name' => 'Child Seat',
                'slug' => 'child-seat',
                'description' => 'Safety seat for children (0-4 years)',
                'pricing_type' => 'daily',
                'price' => 50000,
                'icon' => '👶',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_id' => $safetyCategory->id,
                'name' => 'Booster Seat',
                'slug' => 'booster-seat',
                'description' => 'Booster seat for children (4-8 years)',
                'pricing_type' => 'daily',
                'price' => 40000,
                'icon' => '🧒',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_id' => $safetyCategory->id,
                'name' => 'First Aid Kit',
                'slug' => 'first-aid-kit',
                'description' => 'Complete first aid kit for emergencies',
                'pricing_type' => 'fixed',
                'price' => 25000,
                'icon' => '🩹',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Comfort
            [
                'category_id' => $comfortCategory->id,
                'name' => 'Pillow & Blanket',
                'slug' => 'pillow-blanket',
                'description' => 'Comfortable pillow and blanket set',
                'pricing_type' => 'daily',
                'price' => 30000,
                'icon' => '🛏️',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_id' => $comfortCategory->id,
                'name' => 'Sunshade',
                'slug' => 'sunshade',
                'description' => 'Window sunshade for UV protection',
                'pricing_type' => 'fixed',
                'price' => 15000,
                'icon' => '🌞',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Technology
            [
                'category_id' => $techCategory->id,
                'name' => 'GPS Navigation',
                'slug' => 'gps-navigation',
                'description' => 'Portable GPS device with updated maps',
                'pricing_type' => 'daily',
                'price' => 75000,
                'icon' => '🗺️',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_id' => $techCategory->id,
                'name' => 'Phone Charger',
                'slug' => 'phone-charger',
                'description' => 'Universal phone car charger',
                'pricing_type' => 'fixed',
                'price' => 20000,
                'icon' => '🔌',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_id' => $techCategory->id,
                'name' => 'WiFi Hotspot',
                'slug' => 'wifi-hotspot',
                'description' => 'Portable WiFi hotspot device',
                'pricing_type' => 'daily',
                'price' => 100000,
                'icon' => '📶',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Luggage
            [
                'category_id' => $luggageCategory->id,
                'name' => 'Roof Rack',
                'slug' => 'roof-rack',
                'description' => 'Additional roof rack for extra luggage',
                'pricing_type' => 'daily',
                'price' => 100000,
                'icon' => '🚗',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_id' => $luggageCategory->id,
                'name' => 'Cargo Box',
                'slug' => 'cargo-box',
                'description' => 'Weatherproof cargo box for luggage',
                'pricing_type' => 'daily',
                'price' => 150000,
                'icon' => '📦',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($addons as $addon) {
            Addon::updateOrCreate(
                ['slug' => $addon['slug']],
                $addon
            );
        }
    }
}
