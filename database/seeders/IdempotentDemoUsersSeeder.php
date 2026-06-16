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
        // Demo admin (password fixed)
        User::updateOrCreate(
            ['email' => 'admin@asrgo.com'],
            [
                'id' => Str::uuid(),
                'name' => 'Admin ASR GO',
                'phone' => '083156408078',
                'role' => 'admin',
                'is_verified' => true,
                'password' => Hash::make('admin123'),
            ]
        );

        // Demo regular users (password fixed)
        User::updateOrCreate(
            ['email' => 'user1@asrgo.com'],
            [
                'id' => Str::uuid(),
                'name' => 'User One',
                'phone' => '081234567891',
                'role' => 'customer',
                'is_verified' => true,
                'password' => Hash::make('user123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user2@asrgo.com'],
            [
                'id' => Str::uuid(),
                'name' => 'User Two',
                'phone' => '081234567892',
                'role' => 'customer',
                'is_verified' => true,
                'password' => Hash::make('user123'),
            ]
        );
    }
}

