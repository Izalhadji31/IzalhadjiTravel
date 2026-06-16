<?php

namespace Database\Seeders;

use App\Models\Armada;
use App\Models\Mitra;
use Illuminate\Database\Seeder;

class ArmadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a default mitra
        $mitra = Mitra::first() ?? Mitra::create([
            'name' => 'ASR GO Fleet',
            'phone' => '1500009',
            'email' => 'fleet@asrgo.com',
            'address' => 'Jl. Soekarno-Hatta, Ende, NTT',
            'bank_account' => '1234567890',
            'bank_name' => 'BCA',
            'commission_percentage' => 10,
        ]);

        // Sample vehicles data
        $vehicles = [
            // Avanza (6 seater)
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Budi Santoso',
                'driver_phone' => '081234567890',
                'plate_number' => 'FI-1234-AB',
                'vehicle_type' => 'Avanza',
                'seat_capacity' => 6,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(2),
                'last_maintenance_date' => now()->subMonths(1),
            ],
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Doni Hermawan',
                'driver_phone' => '081234567891',
                'plate_number' => 'FI-1235-AB',
                'vehicle_type' => 'Avanza',
                'seat_capacity' => 6,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(2),
                'last_maintenance_date' => now()->subMonths(1),
            ],
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Rudi Hartono',
                'driver_phone' => '081234567892',
                'plate_number' => 'FI-1236-AB',
                'vehicle_type' => 'Avanza',
                'seat_capacity' => 6,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(1),
                'last_maintenance_date' => now()->subMonths(2),
            ],

            // Innova (7 seater)
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Ahmad Suryanto',
                'driver_phone' => '081234567893',
                'plate_number' => 'FI-2001-AB',
                'vehicle_type' => 'Innova',
                'seat_capacity' => 7,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(3),
                'last_maintenance_date' => now()->subMonths(1),
            ],
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Wendi Prasetyo',
                'driver_phone' => '081234567894',
                'plate_number' => 'FI-2002-AB',
                'vehicle_type' => 'Innova',
                'seat_capacity' => 7,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(2),
                'last_maintenance_date' => now()->subMonths(1),
            ],
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Hendra Kusuma',
                'driver_phone' => '081234567895',
                'plate_number' => 'FI-2003-AB',
                'vehicle_type' => 'Innova',
                'seat_capacity' => 7,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(1),
                'last_maintenance_date' => now()->subMonths(3),
            ],

            // Hiace (15 seater)
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Samsul Arifin',
                'driver_phone' => '081234567896',
                'plate_number' => 'FI-3001-AB',
                'vehicle_type' => 'Hiace',
                'seat_capacity' => 15,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(3),
                'last_maintenance_date' => now()->subMonths(2),
            ],
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Bambang Sutrisno',
                'driver_phone' => '081234567897',
                'plate_number' => 'FI-3002-AB',
                'vehicle_type' => 'Hiace',
                'seat_capacity' => 15,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(2),
                'last_maintenance_date' => now()->subMonths(1),
            ],
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Yusuf Rahman',
                'driver_phone' => '081234567898',
                'plate_number' => 'FI-3003-AB',
                'vehicle_type' => 'Hiace',
                'seat_capacity' => 15,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(1),
                'last_maintenance_date' => now()->subMonths(1),
            ],

            // Elf (12 seater)
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Imam Gunawan',
                'driver_phone' => '081234567899',
                'plate_number' => 'FI-4001-AB',
                'vehicle_type' => 'Elf',
                'seat_capacity' => 12,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(2),
                'last_maintenance_date' => now()->subMonths(1),
            ],
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Kamal Anggoro',
                'driver_phone' => '081234567900',
                'plate_number' => 'FI-4002-AB',
                'vehicle_type' => 'Elf',
                'seat_capacity' => 12,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(3),
                'last_maintenance_date' => now()->subMonths(2),
            ],
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Luki Setiawan',
                'driver_phone' => '081234567901',
                'plate_number' => 'FI-4003-AB',
                'vehicle_type' => 'Elf',
                'seat_capacity' => 12,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(1),
                'last_maintenance_date' => now()->subMonths(3),
            ],

            // Fortuner (7 seater Premium)
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Mayoko Praditya',
                'driver_phone' => '081234567902',
                'plate_number' => 'FI-5001-AB',
                'vehicle_type' => 'Fortuner',
                'seat_capacity' => 7,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(1),
                'last_maintenance_date' => now()->subMonths(1),
            ],
            [
                'mitra_id' => $mitra->id,
                'driver_name' => 'Narendra Wijaya',
                'driver_phone' => '081234567903',
                'plate_number' => 'FI-5002-AB',
                'vehicle_type' => 'Fortuner',
                'seat_capacity' => 7,
                'status' => 'tersedia',
                'purchase_date' => now()->subYears(2),
                'last_maintenance_date' => now()->subMonths(1),
            ],
        ];

        // Create vehicles
        foreach ($vehicles as $vehicle) {
            Armada::firstOrCreate(
                ['plate_number' => $vehicle['plate_number']],
                $vehicle
            );
        }

        $this->command->info('✅ ' . count($vehicles) . ' kendaraan telah ditambahkan');
    }
}
