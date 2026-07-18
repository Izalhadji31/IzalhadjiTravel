<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Route;
use App\Models\TravelPrice;
use Illuminate\Support\Str;

$routesData = [
    // Ende connections
    ['origin' => 'Ende', 'dest' => 'Maumere', 'km' => 60, 'hours' => 1.5, 'price' => 75000],
    ['origin' => 'Ende', 'dest' => 'Bajawa', 'km' => 120, 'hours' => 3, 'price' => 120000],
    ['origin' => 'Ende', 'dest' => 'Ruteng', 'km' => 180, 'hours' => 4.5, 'price' => 180000],
    ['origin' => 'Ende', 'dest' => 'Labuan Bajo', 'km' => 350, 'hours' => 8, 'price' => 350000],
    
    // Maumere connections
    ['origin' => 'Maumere', 'dest' => 'Ende', 'km' => 60, 'hours' => 1.5, 'price' => 75000],
    ['origin' => 'Maumere', 'dest' => 'Larantuka', 'km' => 140, 'hours' => 3.5, 'price' => 150000],
    
    // Bajawa connections
    ['origin' => 'Bajawa', 'dest' => 'Ende', 'km' => 120, 'hours' => 3, 'price' => 120000],
    ['origin' => 'Bajawa', 'dest' => 'Ruteng', 'km' => 80, 'hours' => 2, 'price' => 90000],
    
    // Ruteng connections
    ['origin' => 'Ruteng', 'dest' => 'Bajawa', 'km' => 80, 'hours' => 2, 'price' => 90000],
    ['origin' => 'Ruteng', 'dest' => 'Labuan Bajo', 'km' => 150, 'hours' => 4, 'price' => 180000],
    ['origin' => 'Ruteng', 'dest' => 'Borong', 'km' => 45, 'hours' => 1.5, 'price' => 50000],
    
    // Labuan Bajo connections
    ['origin' => 'Labuan Bajo', 'dest' => 'Ruteng', 'km' => 150, 'hours' => 4, 'price' => 180000],
    ['origin' => 'Labuan Bajo', 'dest' => 'Borong', 'km' => 120, 'hours' => 3, 'price' => 150000],
    
    // Larantuka connections
    ['origin' => 'Larantuka', 'dest' => 'Maumere', 'km' => 140, 'hours' => 3.5, 'price' => 150000],
    
    // Borong connections
    ['origin' => 'Borong', 'dest' => 'Ruteng', 'km' => 45, 'hours' => 1.5, 'price' => 50000],
    ['origin' => 'Borong', 'dest' => 'Labuan Bajo', 'km' => 120, 'hours' => 3, 'price' => 150000],
    
    // Mbay connections
    ['origin' => 'Mbay', 'dest' => 'Ende', 'km' => 30, 'hours' => 1, 'price' => 40000],
    ['origin' => 'Mbay', 'dest' => 'Bajawa', 'km' => 50, 'hours' => 1.5, 'price' => 60000],
];

foreach ($routesData as $data) {
    $route = Route::updateOrCreate(
        ['origin_city' => $data['origin'], 'destination_city' => $data['dest']],
        [
            'id' => (string) Str::uuid(),
            'name' => $data['origin'] . ' - ' . $data['dest'],
            'origin_city' => $data['origin'],
            'destination_city' => $data['dest'],
            'distance_km' => $data['km'],
            'estimated_hours' => $data['hours'],
            'route_type' => 'travel',
            'is_active' => true,
        ]
    );
    
    TravelPrice::updateOrCreate(
        ['route_id' => $route->id],
        [
            'id' => (string) Str::uuid(),
            'route_id' => $route->id,
            'price_per_seat' => $data['price'],
            'is_active' => true,
        ]
    );
    
    echo "Created: {$data['origin']} -> {$data['dest']} (Rp{$data['price']})\n";
}

echo "Done!\n";