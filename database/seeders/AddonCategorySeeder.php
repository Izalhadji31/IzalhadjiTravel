<?php

namespace Database\Seeders;

use App\Models\AddonCategory;
use Illuminate\Database\Seeder;

class AddonCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Safety',
                'slug' => 'safety',
                'description' => 'Safety equipment for your journey',
                'icon' => '🛡️',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Comfort',
                'slug' => 'comfort',
                'description' => 'Additional comfort items',
                'icon' => '😊',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Tech accessories for navigation and entertainment',
                'icon' => '📱',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Luggage',
                'slug' => 'luggage',
                'description' => 'Extra storage for your belongings',
                'icon' => '🧳',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            AddonCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
