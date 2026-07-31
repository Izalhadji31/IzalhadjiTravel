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
     */
    public function run(): void
    {
        // Create Super Admin user first (without company)
        $superAdmin = User::create([
            'id' => Str::uuid(),
            'name' => 'Super Admin',
            'email' => 'superadmin@asrgo.com',
            'password' => bcrypt('password123'),
            'phone' => '+62812345670',
            'role' => 'admin',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Company 1: CV. Izalhadji Travel
        $company1 = Company::create([
            'id' => Str::uuid(),
            'name' => 'CV. Izalhadji Travel',
            'slug' => 'izalhadji-travel',
            'email' => 'admin@izalhadji.com',
            'phone' => '+62812345671',
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
            'subscription_start_date' => now(),
            'subscription_end_date' => now()->addYear(),
            'status' => 'active',
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        // Create admin user for Company 1
        $admin1 = User::create([
            'id' => Str::uuid(),
            'company_id' => $company1->id,
            'name' => 'Admin Izalhadji',
            'email' => 'admin@izalhadji.com',
            'password' => bcrypt('password123'),
            'phone' => '+62812345671',
            'role' => 'admin',
            'is_verified' => true,
            'is_active' => true,
        ]);

        $company1->update(['admin_user_id' => $admin1->id]);

        // Create sample users for Company 1
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'id' => Str::uuid(),
                'company_id' => $company1->id,
                'name' => 'Customer ' . $i,
                'email' => "customer{$i}@izalhadji.com",
                'password' => bcrypt('password123'),
                'phone' => '+6281234567' . (71 + $i),
                'role' => 'customer',
                'is_verified' => true,
                'is_active' => true,
            ]);
        }

        // Create sample drivers for Company 1
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'id' => Str::uuid(),
                'company_id' => $company1->id,
                'name' => 'Driver ' . $i,
                'email' => "driver{$i}@izalhadji.com",
                'password' => bcrypt('password123'),
                'phone' => '+6281234567' . (81 + $i),
                'role' => 'driver',
                'is_verified' => true,
                'is_active' => true,
            ]);
        }

        // Company 2: Flores Jaya Travel
        $company2 = Company::create([
            'id' => Str::uuid(),
            'name' => 'Flores Jaya Travel',
            'slug' => 'flores-jaya-travel',
            'email' => 'admin@floresjaya.com',
            'phone' => '+62812345680',
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
            'subscription_start_date' => now(),
            'subscription_end_date' => now()->addYear(),
            'status' => 'active',
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        $admin2 = User::create([
            'id' => Str::uuid(),
            'company_id' => $company2->id,
            'name' => 'Admin Flores Jaya',
            'email' => 'admin@floresjaya.com',
            'password' => bcrypt('password123'),
            'phone' => '+62812345680',
            'role' => 'admin',
            'is_verified' => true,
            'is_active' => true,
        ]);

        $company2->update(['admin_user_id' => $admin2->id]);

        // Company 3: NTT Express (Trial)
        $company3 = Company::create([
            'id' => Str::uuid(),
            'name' => 'NTT Express',
            'slug' => 'ntt-express',
            'email' => 'admin@nttexpress.com',
            'phone' => '+62812345690',
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
            'subscription_start_date' => now(),
            'subscription_end_date' => now()->addMonth(),
            'status' => 'trial',
            'is_verified' => false,
        ]);

        $admin3 = User::create([
            'id' => Str::uuid(),
            'company_id' => $company3->id,
            'name' => 'Admin NTT Express',
            'email' => 'admin@nttexpress.com',
            'password' => bcrypt('password123'),
            'phone' => '+62812345690',
            'role' => 'admin',
            'is_verified' => true,
            'is_active' => true,
        ]);

        $company3->update(['admin_user_id' => $admin3->id]);

        echo "✅ Company seeder completed!\n";
        echo "Total companies created: 3\n";
        echo "Super Admin email: superadmin@asrgo.com / password123\n";
    }
}
