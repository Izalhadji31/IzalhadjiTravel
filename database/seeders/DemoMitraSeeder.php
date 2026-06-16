<?php

namespace Database\Seeders;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoMitraSeeder extends Seeder
{
    public function run(): void
    {
        // Create mitra users first
        $mitraUser1 = User::updateOrCreate(
            ['email' => 'mitra1@asrgo.com'],
            [
                'name' => 'PT. Jaya Transport',
                'phone' => '081234567901',
                'role' => 'partner',
                'is_verified' => true,
                'password' => Hash::make('mitra123'),
            ]
        );

        $mitraUser2 = User::updateOrCreate(
            ['email' => 'mitra2@asrgo.com'],
            [
                'name' => 'PT. Flores Travels',
                'phone' => '081234567902',
                'role' => 'partner',
                'is_verified' => true,
                'password' => Hash::make('mitra123'),
            ]
        );

        // Mitra 1
        Mitra::updateOrCreate(
            ['email' => 'mitra1@asrgo.com'],
            [
                'name' => 'PT. Jaya Transport',
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 1, Ende',
                'city' => 'Ende',
                'bank_name' => 'Bank BRI',
                'bank_account' => '9001234567890',
                'bank_holder' => 'PT. Jaya Transport',
                'is_active' => true,
                'revenue_share_percentage' => 70.00,
                'total_earnings' => 50000000,
            ]
        );

        // Mitra 2
        Mitra::updateOrCreate(
            ['email' => 'mitra2@asrgo.com'],
            [
                'name' => 'PT. Flores Travels',
                'phone' => '081234567892',
                'address' => 'Jl. Ahmad Yani No. 2, Ende',
                'city' => 'Ende',
                'bank_name' => 'Bank BNI',
                'bank_account' => '9019876543210',
                'bank_holder' => 'PT. Flores Travels',
                'is_active' => true,
                'revenue_share_percentage' => 70.00,
                'total_earnings' => 35000000,
            ]
        );
    }
}
