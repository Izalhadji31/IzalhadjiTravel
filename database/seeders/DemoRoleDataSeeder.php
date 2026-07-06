<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DemoRoleDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ============================================================
        // REUSABLE IDENTIFIERS
        // ============================================================
        $mitra1Id = 1; // PT. Jaya Transport
        $driverUserId = '019f0eff-5bf4-7358-a2c7-1c8737244ac9'; // driver1@asrgo.com
        $customerIds = [
            '715c649f-30f1-4c50-8c84-bca71f95f59d', // Customer 1
            '5cda975d-fd19-4101-ae40-1f345a8fa789', // Customer 2
            '8dbfe85a-0786-4624-b627-b697cce3c4bd', // Customer 3
        ];

        echo "Seeding role-specific demo data...\n";

        // ============================================================
        // 1. TRIP TRACKINGS for driver (armada_id=1)
        //    -> Populates driver earnings trip history table
        // ============================================================
        if (DB::table('trip_trackings')->count() == 0) {
            // We need a rental_booking_id for trip_trackings (since rental_booking_id is NOT NULL)
            // Use the first rental booking that exists
            $rentalBooking = DB::table('rental_bookings')->first();
            $rentalBookingId = $rentalBooking ? $rentalBooking->id : null;

            if (!$rentalBookingId) {
                echo "  ⚠️ No rental bookings found, creating one for trip_trackings...\n";
                // Create a minimal rental booking to satisfy the FK
                $newRentalId = (string) Str::uuid();
                DB::table('rental_bookings')->insert([
                    'id' => $newRentalId,
                    'user_id' => $customerIds[0],
                    'vehicle_id' => '2d46a97a-2684-4143-9bc8-204c99cad1d7',
                    'booking_code' => 'RNT-DEMO-' . strtoupper(Str::random(6)),
                    'start_date' => $now->copy()->subDays(5),
                    'end_date' => $now->copy()->subDays(3),
                    'days' => 2,
                    'daily_rate' => 350000,
                    'total_price' => 700000,
                    'final_price' => 700000,
                    'status' => 'completed',
                    'payment_status' => 'paid',
                    'pickup_location' => 'Kantor ASR GO',
                    'return_location' => 'Kantor ASR GO',
                    'created_at' => $now->copy()->subDays(5),
                    'updated_at' => $now->copy()->subDays(3),
                ]);
                $rentalBookingId = $newRentalId;
                echo "  ✅ Created rental booking: {$newRentalId}\n";
            }

            $trips = [
                [
                    'rental_booking_id' => $rentalBookingId,
                    'armada_id' => 1,
                    'user_id' => $customerIds[0],
                    'start_latitude' => -8.84,
                    'start_longitude' => 121.66,
                    'end_latitude' => -8.85,
                    'end_longitude' => 121.65,
                    'start_address' => 'Kantor ASR GO, Ende',
                    'end_address' => 'Bandara Ende',
                    'total_distance' => 5.2,
                    'average_speed' => 35,
                    'duration_minutes' => 25,
                    'start_time' => $now->copy()->subDays(3)->setHour(8)->setMinute(0),
                    'end_time' => $now->copy()->subDays(3)->setHour(8)->setMinute(25),
                    'status' => 'completed',
                    'created_at' => $now->copy()->subDays(3),
                    'updated_at' => $now->copy()->subDays(3),
                ],
                [
                    'rental_booking_id' => $rentalBookingId,
                    'armada_id' => 1,
                    'user_id' => $customerIds[0],
                    'start_latitude' => -8.84,
                    'start_longitude' => 121.66,
                    'end_latitude' => -8.90,
                    'end_longitude' => 121.70,
                    'start_address' => 'Kantor ASR GO, Ende',
                    'end_address' => 'Pelabuhan Ende',
                    'total_distance' => 8.0,
                    'average_speed' => 30,
                    'duration_minutes' => 16,
                    'start_time' => $now->copy()->subDays(5)->setHour(14)->setMinute(0),
                    'end_time' => $now->copy()->subDays(5)->setHour(14)->setMinute(16),
                    'status' => 'completed',
                    'created_at' => $now->copy()->subDays(5),
                    'updated_at' => $now->copy()->subDays(5),
                ],
                [
                    'rental_booking_id' => $rentalBookingId,
                    'armada_id' => 1,
                    'user_id' => $customerIds[1],
                    'start_latitude' => -8.84,
                    'start_longitude' => 121.66,
                    'end_latitude' => -8.50,
                    'end_longitude' => 121.30,
                    'start_address' => 'Bandara Ende',
                    'end_address' => 'Hotel Flores, Mbay',
                    'total_distance' => 45.0,
                    'average_speed' => 50,
                    'duration_minutes' => 60,
                    'start_time' => $now->copy()->subDays(7)->setHour(10)->setMinute(0),
                    'end_time' => $now->copy()->subDays(7)->setHour(11)->setMinute(0),
                    'status' => 'completed',
                    'created_at' => $now->copy()->subDays(7),
                    'updated_at' => $now->copy()->subDays(7),
                ],
            ];

            foreach ($trips as $trip) {
                DB::table('trip_trackings')->insert($trip);
            }
            echo "  ✅ Trip Trackings: " . count($trips) . " completed trips inserted for armada 1\n";

            // Update the driver's total_trips to reflect these
            DB::table('drivers')
                ->where('user_id', $driverUserId)
                ->increment('total_trips', count($trips));
            echo "  ✅ Driver total_trips incremented by " . count($trips) . "\n";

        } else {
            echo "  ⏭️ Trip Trackings already exist, skipping\n";
        }

        // ============================================================
        // 2. NOTIFICATIONS for driver1@asrgo.com
        // ============================================================
        $existingNotifications = DB::table('notifications')
            ->where('user_id', $driverUserId)
            ->count();

        if ($existingNotifications == 0) {
            $notifications = [
                [
                    'user_id' => $driverUserId,
                    'type' => 'in_app',
                    'trigger' => 'armada_assigned',
                    'notifiable_type' => 'App\Models\Armada',
                    'notifiable_id' => 1,
                    'title' => 'Armada Ditugaskan',
                    'message' => 'Anda telah ditugaskan ke armada NTT 1001 (Minibus). Silakan cek detail armada.',
                    'is_read' => 0,
                    'status' => 'sent',
                    'sent_at' => $now->copy()->subDays(10),
                    'created_at' => $now->copy()->subDays(10),
                    'updated_at' => $now->copy()->subDays(10),
                ],
                [
                    'user_id' => $driverUserId,
                    'type' => 'in_app',
                    'trigger' => 'booking_created',
                    'notifiable_type' => 'App\Models\TravelBooking',
                    'notifiable_id' => 0, // generic reference
                    'title' => 'Order Baru Diterima',
                    'message' => 'Ada order travel baru yang ditugaskan ke armada Anda: TRV-CONA0BEO (Ende → Bajawa).',
                    'is_read' => 0,
                    'status' => 'sent',
                    'sent_at' => $now->copy()->subDays(3),
                    'created_at' => $now->copy()->subDays(3),
                    'updated_at' => $now->copy()->subDays(3),
                ],
                [
                    'user_id' => $driverUserId,
                    'type' => 'in_app',
                    'trigger' => 'payment_success',
                    'notifiable_type' => 'App\Models\RevenueSharing',
                    'notifiable_id' => 0,
                    'title' => 'Pendapatan Masuk',
                    'message' => 'Pendapatan sebesar Rp 40.000 telah masuk ke saldo Anda untuk perjalanan Ende - Ruteng.',
                    'is_read' => 0,
                    'status' => 'sent',
                    'sent_at' => $now->copy()->subDays(7),
                    'created_at' => $now->copy()->subDays(7),
                    'updated_at' => $now->copy()->subDays(7),
                ],
                [
                    'user_id' => $driverUserId,
                    'type' => 'in_app',
                    'trigger' => 'trip_departure',
                    'notifiable_type' => 'App\Models\TripTracking',
                    'notifiable_id' => 1,
                    'title' => 'Perjalanan Dimulai',
                    'message' => 'Perjalanan Anda dari Kantor ASR GO ke Bandara Ende telah dimulai. Selamat jalan!',
                    'is_read' => 1,
                    'read_at' => $now->copy()->subDays(3)->addHour(1),
                    'status' => 'sent',
                    'sent_at' => $now->copy()->subDays(3),
                    'created_at' => $now->copy()->subDays(3),
                    'updated_at' => $now->copy()->subDays(3),
                ],
                [
                    'user_id' => $driverUserId,
                    'type' => 'in_app',
                    'trigger' => 'trip_arrival',
                    'notifiable_type' => 'App\Models\TripTracking',
                    'notifiable_id' => 1,
                    'title' => 'Perjalanan Selesai',
                    'message' => 'Perjalanan Anda telah selesai. Terima kasih telah memberikan layanan terbaik!',
                    'is_read' => 1,
                    'read_at' => $now->copy()->subDays(3)->addHour(2),
                    'status' => 'sent',
                    'sent_at' => $now->copy()->subDays(3),
                    'created_at' => $now->copy()->subDays(3),
                    'updated_at' => $now->copy()->subDays(3),
                ],
            ];

            foreach ($notifications as $notif) {
                DB::table('notifications')->insert($notif);
            }
            echo "  ✅ Notifications: " . count($notifications) . " inserted for driver1@asrgo.com\n";
        } else {
            echo "  ⏭️ Notifications already exist for driver, skipping\n";
        }

        // ============================================================
        // 3. REVENUE SHARINGS for mitra_id=1 with driver amounts
        //    -> Also populates driver earnings history
        // ============================================================
        $existingRevenueDriver = DB::table('revenue_sharings')
            ->where('mitra_id', $mitra1Id)
            ->where('driver_amount', '>', 0)
            ->count();

        if ($existingRevenueDriver == 0) {
            // Find a payment to reference
            $payment = DB::table('payments')->first();
            $paymentId = $payment ? $payment->id : (string) Str::uuid();

            // We need integer booking_id values that work with the table schema
            // (booking_id is integer, not varchar, so we can't use UUID)
            $revenues = [
                [
                    'booking_type' => 'App\Models\TravelBooking',
                    'booking_id' => 1001,
                    'payment_id' => $paymentId,
                    'mitra_id' => $mitra1Id,
                    'admin_amount' => 30000,
                    'mitra_amount' => 50000,
                    'driver_amount' => 20000,
                    'admin_percentage' => 30,
                    'mitra_percentage' => 50,
                    'driver_percentage' => 20,
                    'status' => 'completed',
                    'paid_at' => $now->copy()->subDays(2),
                    'created_at' => $now->copy()->subDays(2),
                    'updated_at' => $now->copy()->subDays(2),
                ],
                [
                    'booking_type' => 'App\Models\TravelBooking',
                    'booking_id' => 1002,
                    'payment_id' => $paymentId,
                    'mitra_id' => $mitra1Id,
                    'admin_amount' => 45000,
                    'mitra_amount' => 75000,
                    'driver_amount' => 30000,
                    'admin_percentage' => 30,
                    'mitra_percentage' => 50,
                    'driver_percentage' => 20,
                    'status' => 'pending',
                    'paid_at' => null,
                    'created_at' => $now->copy()->subDays(1),
                    'updated_at' => $now->copy()->subDays(1),
                ],
            ];

            foreach ($revenues as $rev) {
                DB::table('revenue_sharings')->insert($rev);
            }
            echo "  ✅ Revenue Sharings: " . count($revenues) . " with driver amounts inserted for mitra_id=1\n";

            // Update mitra total_earnings
            DB::table('mitras')
                ->where('id', $mitra1Id)
                ->increment('total_earnings', 125000);

        } else {
            echo "  ⏭️ Revenue Sharings with driver amounts already exist, skipping\n";
        }

        // ============================================================
        // 4. UPDATE ARMADA STATUSES for variety on partner dashboard
        // ============================================================
        // Armada 2 → 'jalan' (on the road)
        DB::table('armadas')
            ->where('id', 2)
            ->where('mitra_id', $mitra1Id)
            ->where('status', 'tersedia')
            ->update(['status' => 'jalan', 'updated_at' => $now]);

        // Armada 1 → keep as 'tersedia' (already available)
        // Check if there's an armada 5 we can add as 'maintenance'

        $armada5Exists = DB::table('armadas')->where('plate_number', 'NTT 1003')->exists();
        if (!$armada5Exists) {
            DB::table('armadas')->insert([
                'mitra_id' => $mitra1Id,
                'driver_name' => 'Citra',
                'driver_phone' => '082345678901',
                'plate_number' => 'NTT 1003',
                'vehicle_type' => 'Hiace',
                'seat_capacity' => 12,
                'status' => 'maintenance',
                'purchase_date' => '2024-01-15',
                'last_maintenance_date' => $now->copy()->subDays(5),
                'created_at' => $now->copy()->subDays(60),
                'updated_at' => $now->copy()->subDays(5),
            ]);
            echo "  ✅ Added armada NTT 1003 (Hiace) with status='maintenance' for mitra_id=1\n";

            // Add a maintenance log for this armada
            DB::table('vehicle_maintenance_logs')->insert([
                'armada_id' => 5, // Will be the new armada ID
                'maintenance_type' => 'general_service',
                'description' => 'Servis rutin berkala',
                'cost' => 2000000,
                'maintenance_date' => $now->copy()->subDays(5),
                'scheduled_next_at' => $now->copy()->addMonths(3),
                'status' => 'in_progress',
                'notes' => 'Ganti oli, filter, dan cek kondisi mesin',
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ]);
            echo "  ✅ Added maintenance log for the new armada\n";
        }

        echo "  ✅ Armada statuses updated: #1=tersedia, #2=jalan, #5=maintenance\n";

        // ============================================================
        // 5. ADD AN ACTIVE 'departed' TRAVEL BOOKING for armada 1
        //    -> Shows "Dalam Perjalanan" badge on driver dashboard
        // ============================================================
        $departedExists = DB::table('travel_bookings')
            ->where('assigned_armada_id', 1)
            ->where('status', 'departed')
            ->exists();

        if (!$departedExists) {
            // Get a route ID
            $route = DB::table('routes')->first();
            if ($route) {
                $newBookingId = (string) Str::uuid();
                DB::table('travel_bookings')->insert([
                    'id' => $newBookingId,
                    'user_id' => $customerIds[2],
                    'route_id' => $route->id,
                    'vehicle_id' => null,
                    'booking_code' => 'TRV-DEMO-' . strtoupper(Str::random(6)),
                    'passenger_count' => 2,
                    'total_price' => 300000,
                    'final_price' => 300000,
                    'number_of_seats' => 2,
                    'status' => 'departed',
                    'payment_status' => 'paid',
                    'scheduled_date' => $now->format('Y-m-d'),
                    'departure_time' => $now->copy()->subHours(2),
                    'assigned_armada_id' => 1,
                    'passenger_details' => json_encode([
                        ['name' => 'Penumpang 1', 'phone' => '08123456701'],
                        ['name' => 'Penumpang 2', 'phone' => '08123456702'],
                    ]),
                    'created_at' => $now->copy()->subDays(1),
                    'updated_at' => $now->copy()->subHours(2),
                ]);
                echo "  ✅ Added 'departed' travel booking for armada 1 (shows 'Dalam Perjalanan' on driver dashboard)\n";
            }
        }

        // ============================================================
        // 6. ADD A RENTAL BOOKING with driver_fee for armada 1
        //    (since rental_bookings doesn't have assigned_armada_id,
        //     this is just for completeness)
        // ============================================================
        // Skipping - rental_bookings doesn't have assigned_armada_id column

        echo "\n✅ DemoRoleDataSeeder completed successfully!\n";
    }
}
