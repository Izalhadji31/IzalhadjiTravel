<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Route;

$routes = Route::where('is_active', true)->get();

foreach ($routes as $route) {
    // Set departure times based on route distance
    if ($route->distance_km <= 60) {
        // Short routes - more frequent
        $times = ['06:00', '09:00', '12:00', '15:00', '18:00', '20:00'];
    } elseif ($route->distance_km <= 150) {
        // Medium routes
        $times = ['07:00', '11:00', '15:00', '19:00'];
    } else {
        // Long routes
        $times = ['08:00', '14:00', '19:30'];
    }
    
    $route->update(['departure_times' => $times]);
    echo "Updated: {$route->origin_city} -> {$route->destination_city} (times: " . implode(', ', $times) . ")\n";
}

echo "Done!\n";