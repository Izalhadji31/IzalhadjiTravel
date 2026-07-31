<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class IdempotentDemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Skip users that are already created by CompanySeeder
        $existingEmails = ['superadmin@asrgo.com', 'admin@izalhadji.com', 'admin@floresjaya.com', 'admin@nttexpress.com'];

        // Demo admin (asrgo.test domain)
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@asrgo.test'],
            [
                'id' => Str::uuid(),
                'name' => 'Admin Demo',
                'phone' => '081333333333',
                'role' => 'admin',
                'is_verified' => true,
                'password' => Hash::make('password'),
            ]
        );
        $adminUser->assignRole('admin');

        // Demo customer (asrgo.test domain)
        $customerUser = User::updateOrCreate(
            ['email' => 'customer@asrgo.test'],
            [
                'id' => Str::uuid(),
                'name' => 'Customer Demo',
                'phone' => '081444444444',
                'role' => 'customer',
                'is_verified' => true,
                'password' => Hash::make('password'),
            ]
        );
        $customerUser->assignRole('customer');

        // Demo driver (asrgo.test domain)
        $driverUser = User::updateOrCreate(
            ['email' => 'driver@asrgo.test'],
            [
                'id' => Str::uuid(),
                'name' => 'Driver Demo',
                'phone' => '081555555555',
                'role' => 'driver',
                'is_verified' => true,
                'password' => Hash::make('password'),
            ]
        );
        $driverUser->assignRole('driver');

        // Demo partner (asrgo.test domain)
        $partnerUser = User::updateOrCreate(
            ['email' => 'partner@asrgo.test'],
            [
                'id' => Str::uuid(),
                'name' => 'Partner Demo',
                'phone' => '081666666666',
                'role' => 'partner',
                'is_verified' => true,
                'password' => Hash::make('password'),
            ]
        );
        $partnerUser->assignRole('partner');
    }
}

