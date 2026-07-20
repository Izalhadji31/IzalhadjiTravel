<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Driver;
use App\Models\Mitra;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Seed all users: admin, customer, driver, mitra.
     * Idempotent — aman dijalankan berkali-kali.
     */
    public function run(): void
    {
        $now = now();
        $defaultPassword = 'password123';

        // ============================================================
        // 1. ADMIN
        // ============================================================
        $admin = User::updateOrCreate(
            ['email' => 'admin@asrgo.com'],
            [
                'name' => 'Admin ASR GO',
                'phone' => '083156408078',
                'role' => 'admin',
                'is_verified' => true,
                'is_active' => true,
                'email_verified_at' => $now,
                'status' => 'approved',
                'password' => Hash::make($defaultPassword),
            ]
        );
        $this->command->info("  ✅ Admin: admin@asrgo.com / {$defaultPassword}");

        // ============================================================
        // 2. SUPER ADMIN
        // ============================================================
        User::updateOrCreate(
            ['email' => 'superadmin@asrgo.com'],
            [
                'name' => 'Super Admin',
                'phone' => '083156408079',
                'role' => 'super_admin',
                'is_verified' => true,
                'is_active' => true,
                'email_verified_at' => $now,
                'status' => 'approved',
                'password' => Hash::make($defaultPassword),
            ]
        );
        $this->command->info("  ✅ Super Admin: superadmin@asrgo.com / {$defaultPassword}");

        // ============================================================
        // 3. MITRA (PARTNER) — User + Mitra Profile
        // ============================================================
        $mitraData = [
            [
                'user' => [
                    'name' => 'PT. Jaya Transport',
                    'email' => 'mitra1@asrgo.com',
                    'phone' => '081234567901',
                    'role' => 'partner',
                ],
                'mitra' => [
                    'name' => 'PT. Jaya Transport',
                    'email' => 'mitra1@asrgo.com',
                    'phone' => '081234567891',
                    'address' => 'Jl. Sudirman No. 1, Ende',
                    'city' => 'Ende',
                    'bank_name' => 'Bank BRI',
                    'bank_account' => '9001234567890',
                    'bank_holder' => 'PT. Jaya Transport',
                    'is_active' => true,
                    'revenue_share_percentage' => 70.00,
                    'total_earnings' => 50000000,
                ],
            ],
            [
                'user' => [
                    'name' => 'PT. Flores Travels',
                    'email' => 'mitra2@asrgo.com',
                    'phone' => '081234567902',
                    'role' => 'partner',
                ],
                'mitra' => [
                    'name' => 'PT. Flores Travels',
                    'email' => 'mitra2@asrgo.com',
                    'phone' => '081234567892',
                    'address' => 'Jl. Ahmad Yani No. 2, Ende',
                    'city' => 'Ende',
                    'bank_name' => 'Bank BNI',
                    'bank_account' => '9019876543210',
                    'bank_holder' => 'PT. Flores Travels',
                    'is_active' => true,
                    'revenue_share_percentage' => 70.00,
                    'total_earnings' => 35000000,
                ],
            ],
            [
                'user' => [
                    'name' => 'CV. Flores Mandiri',
                    'email' => 'mitra3@asrgo.com',
                    'phone' => '081234567903',
                    'role' => 'partner',
                ],
                'mitra' => [
                    'name' => 'CV. Flores Mandiri',
                    'email' => 'mitra3@asrgo.com',
                    'phone' => '081234567893',
                    'address' => 'Jl. Gajah Mada No. 5, Labuan Bajo',
                    'city' => 'Labuan Bajo',
                    'bank_name' => 'Bank Mandiri',
                    'bank_account' => '9023456789012',
                    'bank_holder' => 'CV. Flores Mandiri',
                    'is_active' => true,
                    'revenue_share_percentage' => 65.00,
                    'total_earnings' => 25000000,
                ],
            ],
        ];

        foreach ($mitraData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['user']['email']],
                array_merge($data['user'], [
                    'is_verified' => true,
                    'is_active' => true,
                    'email_verified_at' => $now,
                    'status' => 'approved',
                    'password' => Hash::make($defaultPassword),
                ])
            );

            Mitra::updateOrCreate(
                ['email' => $data['mitra']['email']],
                $data['mitra']
            );

            $this->command->info("  ✅ Mitra: {$data['user']['email']} / {$defaultPassword}");
        }

        // ============================================================
        // 4. DRIVER (SOPIR) — User + Driver Profile
        // ============================================================
        $driverData = [
            [
                'user' => [
                    'name' => 'Ahmad Fauzi',
                    'email' => 'driver1@asrgo.com',
                    'phone' => '081234567893',
                    'role' => 'driver',
                ],
                'driver' => [
                    'phone' => '081234567893',
                    'sim_number' => 'SIM-001-2024',
                    'sim_expiry' => $now->copy()->addYears(5),
                    'address' => 'Jl. Sudirman No. 1, Ende',
                    'status' => 'available',
                    'rating' => 4.8,
                    'total_trips' => 125,
                    'balance' => 500000,
                ],
            ],
            [
                'user' => [
                    'name' => 'Budi Santoso',
                    'email' => 'driver2@asrgo.com',
                    'phone' => '081234567894',
                    'role' => 'driver',
                ],
                'driver' => [
                    'phone' => '081234567894',
                    'sim_number' => 'SIM-002-2024',
                    'sim_expiry' => $now->copy()->addYears(5),
                    'address' => 'Jl. Ahmad Yani No. 2, Ende',
                    'status' => 'available',
                    'rating' => 4.6,
                    'total_trips' => 98,
                    'balance' => 350000,
                ],
            ],
            [
                'user' => [
                    'name' => 'Citra Dewi',
                    'email' => 'driver3@asrgo.com',
                    'phone' => '081234567895',
                    'role' => 'driver',
                ],
                'driver' => [
                    'phone' => '081234567895',
                    'sim_number' => 'SIM-003-2024',
                    'sim_expiry' => $now->copy()->addYears(5),
                    'address' => 'Jl. Pahlawan No. 3, Maumere',
                    'status' => 'available',
                    'rating' => 4.9,
                    'total_trips' => 210,
                    'balance' => 750000,
                ],
            ],
            [
                'user' => [
                    'name' => 'Dedi Kurniawan',
                    'email' => 'driver4@asrgo.com',
                    'phone' => '081234567896',
                    'role' => 'driver',
                ],
                'driver' => [
                    'phone' => '081234567896',
                    'sim_number' => 'SIM-004-2024',
                    'sim_expiry' => $now->copy()->addYears(5),
                    'address' => 'Jl. Merdeka No. 10, Labuan Bajo',
                    'status' => 'available',
                    'rating' => 4.7,
                    'total_trips' => 156,
                    'balance' => 620000,
                ],
            ],
            [
                'user' => [
                    'name' => 'Eko Prasetyo',
                    'email' => 'driver5@asrgo.com',
                    'phone' => '081234567897',
                    'role' => 'driver',
                ],
                'driver' => [
                    'phone' => '081234567897',
                    'sim_number' => 'SIM-005-2024',
                    'sim_expiry' => $now->copy()->addYears(5),
                    'address' => 'Jl. Diponegoro No. 7, Ruteng',
                    'status' => 'available',
                    'rating' => 4.5,
                    'total_trips' => 78,
                    'balance' => 280000,
                ],
            ],
        ];

        foreach ($driverData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['user']['email']],
                array_merge($data['user'], [
                    'is_verified' => true,
                    'is_active' => true,
                    'email_verified_at' => $now,
                    'status' => 'approved',
                    'password' => Hash::make($defaultPassword),
                ])
            );

            Driver::updateOrCreate(
                ['user_id' => $user->id],
                $data['driver']
            );

            $this->command->info("  ✅ Driver: {$data['user']['email']} / {$defaultPassword}");
        }

        // ============================================================
        // 5. CUSTOMER (REGULAR USER)
        // ============================================================
        $customerData = [
            [
                'name' => 'User Satu',
                'email' => 'user1@asrgo.com',
                'phone' => '081234567891',
            ],
            [
                'name' => 'User Dua',
                'email' => 'user2@asrgo.com',
                'phone' => '081234567892',
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar@example.com',
                'phone' => '081234567898',
            ],
            [
                'name' => 'Gita Permata',
                'email' => 'gita@example.com',
                'phone' => '081234567899',
            ],
            [
                'name' => 'Hendra Gunawan',
                'email' => 'hendra@example.com',
                'phone' => '081234567800',
            ],
        ];

        foreach ($customerData as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'role' => 'customer',
                    'is_verified' => true,
                    'is_active' => true,
                    'email_verified_at' => $now,
                    'status' => 'approved',
                    'password' => Hash::make($defaultPassword),
                ]
            );

            $this->command->info("  ✅ Customer: {$data['email']} / {$defaultPassword}");
        }

        // ============================================================
        // SUMMARY
        // ============================================================
        $total = User::count();
        $this->command->info("");
        $this->command->info("  ===============================");
        $this->command->info("  ✅ TOTAL USER DI DATABASE: {$total}");
        $this->command->info("  ===============================");
        $this->command->info("");
        $this->command->info("  Semua password: {$defaultPassword}");
        $this->command->info("  Admin:   admin@asrgo.com");
        $this->command->info("  Mitra:   mitra1@asrgo.com, mitra2@asrgo.com, mitra3@asrgo.com");
        $this->command->info("  Driver:  driver1@asrgo.com s.d. driver5@asrgo.com");
        $this->command->info("  User:    user1@asrgo.com, user2@asrgo.com, + 3 lainnya");
    }
}
