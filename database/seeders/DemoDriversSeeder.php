<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDriversSeeder extends Seeder
{
    public function run(): void
    {
        // Create driver users first
        $driverUser1 = User::updateOrCreate(
            ['email' => 'driver1@asrgo.com'],
            [
                'name' => 'Driver One',
                'phone' => '081234567893',
                'role' => 'driver',
                'is_verified' => true,
                'password' => Hash::make('driver123'),
            ]
        );

        $driverUser2 = User::updateOrCreate(
            ['email' => 'driver2@asrgo.com'],
            [
                'name' => 'Driver Two',
                'phone' => '081234567894',
                'role' => 'driver',
                'is_verified' => true,
                'password' => Hash::make('driver123'),
            ]
        );

        // Create driver profiles
        Driver::updateOrCreate(
            ['user_id' => $driverUser1->id],
            [
                'phone' => '081234567893',
                'sim_number' => 'SIM-001-2024',
                'sim_expiry' => now()->addYears(5),
                'address' => 'Jl. Sudirman No. 1, Ende',
                'status' => 'available',
                'rating' => 4.8,
                'total_trips' => 125,
                'balance' => 500000,
            ]
        );

        Driver::updateOrCreate(
            ['user_id' => $driverUser2->id],
            [
                'phone' => '081234567894',
                'sim_number' => 'SIM-002-2024',
                'sim_expiry' => now()->addYears(5),
                'address' => 'Jl. Ahmad Yani No. 2, Ende',
                'status' => 'available',
                'rating' => 4.6,
                'total_trips' => 98,
                'balance' => 350000,
            ]
        );
    }
}
