<?php

namespace Tests\Feature;

use App\Models\Armada;
use App\Models\Mitra;
use App\Models\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicHomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_popular_routes_and_available_fleet(): void
    {
        $route = Route::create([
            'name' => 'Ende - Labuan Bajo',
            'origin_city' => 'Ende',
            'destination_city' => 'Labuan Bajo',
            'distance_km' => 350,
            'estimated_hours' => 8,
            'route_type' => 'travel',
            'is_active' => true,
        ]);

        $route->travelPrices()->create([
            'price_per_seat' => 250000,
            'is_active' => true,
        ]);

        $mitra = Mitra::create([
            'name' => 'Test Mitra',
            'phone' => '08123456789',
            'email' => 'mitra@example.com',
            'address' => 'Ende',
            'city' => 'Ende',
            'bank_name' => 'BCA',
            'bank_account' => '1234567890',
            'bank_holder' => 'Test Mitra',
            'is_active' => true,
        ]);

        Armada::create([
            'mitra_id' => $mitra->id,
            'driver_name' => 'Test Driver',
            'driver_phone' => '08123456789',
            'plate_number' => 'DB 1234 XY',
            'vehicle_type' => 'Toyota Avanza',
            'seat_capacity' => 6,
            'status' => 'tersedia',
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Ende');
        $response->assertSee('Labuan Bajo');
        $response->assertSee('Rp 250.000');
        $response->assertSee('Toyota Avanza');
    }
}
