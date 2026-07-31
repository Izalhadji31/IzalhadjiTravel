<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mitra;
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

        // Seed vehicle types for rental
        $this->call(\Database\Seeders\VehicleTypeSeeder::class);

        // Seed addon categories and addons
        $this->call(\Database\Seeders\AddonCategorySeeder::class);
        $this->call(\Database\Seeders\AddonSeeder::class);

        // Insert demo mitras (idempotent)
        $this->call(\Database\Seeders\DemoMitraSeeder::class);

        // Insert demo drivers (idempotent)
        $this->call(\Database\Seeders\DemoDriversSeeder::class);

        // Seed armadas
        $this->call(\Database\Seeders\ArmadaSeeder::class);

        // Seed routes and prices
        $this->call(\Database\Seeders\RouteSeeder::class);

        // Add demo users with standard test credentials
        $this->call(\Database\Seeders\IdempotentDemoUsersSeeder::class);
    }
}
