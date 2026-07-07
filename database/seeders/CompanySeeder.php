<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Idempotent — aman dijalankan berkali-kali.
     */
    public function run(): void
    {
        $now = now();

        // Company 1: CV. Izalhadji Travel
        $company1 = Company::updateOrCreate(
            ['slug' => 'izalhadji-travel'],
            [
                'name' => 'CV. Izalhadji Travel',
                'email' => 'admin@izalhadji.com',
                'phone' => '+628****5671',
                'address' => 'Jl. Imam Bonjol No. 15',
                'city' => 'Ende',
                'province' => 'Nusa Tenggara Timur',
                'postal_code' => '86311',
                'country' => 'Indonesia',
                'description' => 'Travel antar kota dan rental mobil di Pulau Flores',
                'subscription_plan' => 'professional',
                'max_users' => 50,
                'max_vehicles' => 20,
                'features_tracking' => true,
                'features_payment' => true,
                'features_analytics' => true,
                'monthly_fee' => 500000,
                'subscription_start_date' => $now,
                'subscription_end_date' => $now->copy()->addYear(),
                'status' => 'active',
                'is_verified' => true,
                'verified_at' => $now,
            ]
        );

        // Create admin user for Company 1
        $admin1 = User::updateOrCreate(
            ['email' => 'admin@izalhadji.com'],
            [
                'company_id' => $company1->id,
                'name' => 'Admin Izalhadji',
                'password' => bcrypt('password123'),
                'phone' => '+628****5671',
                'role' => 'admin',
                'is_verified' => true,
                'is_active' => true,
            ]
        );

        $company1->update(['admin_user_id' => $admin1->id]);

        // Create sample customers for Company 1
        for ($i = 1; $i <= 3; $i++) {
            User::updateOrCreate(
                ['email' => "customer{$i}@izalhadji.com"],
                [
                    'company_id' => $company1->id,
                    'name' => 'Customer ' . $i,
                    'password' => bcrypt('password123'),
                    'phone' => '+628****4567' . (71 + $i),
                    'role' => 'customer',
                    'is_verified' => true,
                    'is_active' => true,
                ]
            );
        }

        // Create sample drivers for Company 1
        for ($i = 1; $i <= 3; $i++) {
            User::updateOrCreate(
                ['email' => "driver{$i}@izalhadji.com"],
                [
                    'company_id' => $company1->id,
                    'name' => 'Driver ' . $i,
                    'password' => bcrypt('password123'),
                    'phone' => '+628****4567' . (81 + $i),
                    'role' => 'driver',
                    'is_verified' => true,
                    'is_active' => true,
                ]
            );
        }

        // Company 2: Flores Jaya Travel
        $company2 = Company::updateOrCreate(
            ['slug' => 'flores-jaya-travel'],
            [
                'name' => 'Flores Jaya Travel',
                'email' => 'admin@floresjaya.com',
                'phone' => '+628****5680',
                'address' => 'Jl. Ahmad Yani No. 20',
                'city' => 'Maumere',
                'province' => 'Nusa Tenggara Timur',
                'postal_code' => '86113',
                'country' => 'Indonesia',
                'description' => 'Travel premium dengan layanan VIP',
                'subscription_plan' => 'professional',
                'max_users' => 30,
                'max_vehicles' => 15,
                'features_tracking' => true,
                'features_payment' => true,
                'features_analytics' => true,
                'monthly_fee' => 400000,
                'subscription_start_date' => $now,
                'subscription_end_date' => $now->copy()->addYear(),
                'status' => 'active',
                'is_verified' => true,
                'verified_at' => $now,
            ]
        );

        $admin2 = User::updateOrCreate(
            ['email' => 'admin@floresjaya.com'],
            [
                'company_id' => $company2->id,
                'name' => 'Admin Flores Jaya',
                'password' => bcrypt('password123'),
                'phone' => '+628****5680',
                'role' => 'admin',
                'is_verified' => true,
                'is_active' => true,
            ]
        );

        $company2->update(['admin_user_id' => $admin2->id]);

        // Company 3: NTT Express (Trial)
        $company3 = Company::updateOrCreate(
            ['slug' => 'ntt-express'],
            [
                'name' => 'NTT Express',
                'email' => 'admin@nttexpress.com',
                'phone' => '+628****5690',
                'address' => 'Jl. Sudirman No. 45',
                'city' => 'Bajawa',
                'province' => 'Nusa Tenggara Timur',
                'postal_code' => '86410',
                'country' => 'Indonesia',
                'description' => 'Perusahaan transportasi baru dengan teknologi terkini',
                'subscription_plan' => 'starter',
                'max_users' => 10,
                'max_vehicles' => 5,
                'features_tracking' => false,
                'features_payment' => true,
                'features_analytics' => false,
                'monthly_fee' => 200000,
                'subscription_start_date' => $now,
                'subscription_end_date' => $now->copy()->addMonth(),
                'status' => 'trial',
                'is_verified' => false,
            ]
        );

        $admin3 = User::updateOrCreate(
            ['email' => 'admin@nttexpress.com'],
            [
                'company_id' => $company3->id,
                'name' => 'Admin NTT Express',
                'password' => bcrypt('password123'),
                'phone' => '+628****5690',
                'role' => 'admin',
                'is_verified' => true,
                'is_active' => true,
            ]
        );

        $company3->update(['admin_user_id' => $admin3->id]);

        echo "Company seeder completed! Total companies: 3\n";
        echo "Super Admin, admin@izalhadji.com, admin@floresjaya.com, admin@nttexpress.com\n";
    }
}
