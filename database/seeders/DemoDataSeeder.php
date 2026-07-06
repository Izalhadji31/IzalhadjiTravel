<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $superAdminId = '9032071f-2157-4630-b0f8-80aa6eebbd35'; // Super Admin
        $adminId = '97c0e46b-e362-45d5-9ea8-78054ef32ab7';       // Admin Izalhadji
        $customerIds = [
            '715c649f-30f1-4c50-8c84-bca71f95f59d', // Customer 1
            '5cda975d-fd19-4101-ae40-1f345a8fa789', // Customer 2
            '8dbfe85a-0786-4624-b627-b697cce3c4bd', // Customer 3
        ];
        $driverUserIds = [
            '0c633d93-d303-45f8-8ee0-35cfd2689f64', // Driver 1
            '625fd1db-1a02-4867-9f95-fb5a95b38867', // Driver 2
            'c0c061a7-c622-44fa-8f1f-840b494e4b75', // Driver 3
        ];
        $companyId = '797de4db-3df5-48ef-ab18-df2c43879ed0'; // CV. Izalhadji Travel

        echo "Seeding demo data...\n";

        // ==================== NEWSLETTERS ====================
        if (DB::table('newsletters')->count() == 0) {
            $subscribers = [
                ['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'phone' => '081234567890', 'subscribed' => 1],
                ['name' => 'Siti Nurhaliza', 'email' => 'siti@example.com', 'phone' => '081234567891', 'subscribed' => 1],
                ['name' => 'Agus Wijaya', 'email' => 'agus@example.com', 'phone' => '081234567892', 'subscribed' => 1],
                ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'phone' => '081234567893', 'subscribed' => 0],
                ['name' => 'Rudi Hartono', 'email' => 'rudi@example.com', 'phone' => '081234567894', 'subscribed' => 1],
            ];
            foreach ($subscribers as $s) {
                $s['created_at'] = $now->copy()->subDays(rand(1, 60));
                $s['updated_at'] = $now;
                DB::table('newsletters')->insert($s);
            }
            echo "  ✅ Newsletters: " . count($subscribers) . " inserted\n";
        }

        // ==================== SETTINGS ====================
        if (DB::table('settings')->count() == 0) {
            $settings = [
                ['id' => (string) Str::uuid(), 'key' => 'app_name', 'value' => 'ASR GO', 'group' => 'general', 'type' => 'string', 'is_public' => 1],
                ['id' => (string) Str::uuid(), 'key' => 'wa_number', 'value' => '6283156408078', 'group' => 'contact', 'type' => 'string', 'is_public' => 1],
                ['id' => (string) Str::uuid(), 'key' => 'admin_email', 'value' => 'admin@asrgo.com', 'group' => 'contact', 'type' => 'string', 'is_public' => 0],
                ['id' => (string) Str::uuid(), 'key' => 'company_address', 'value' => 'Jl. El Tari No. 21, Ende, NTT', 'group' => 'general', 'type' => 'string', 'is_public' => 1],
                ['id' => (string) Str::uuid(), 'key' => 'tax_percentage', 'value' => '11', 'group' => 'billing', 'type' => 'integer', 'is_public' => 0],
            ];
            foreach ($settings as $s) {
                $s['created_at'] = $now;
                $s['updated_at'] = $now;
                DB::table('settings')->insert($s);
            }
            echo "  ✅ Settings: " . count($settings) . " inserted\n";
        }

        // ==================== VOUCHERS ====================
        if (DB::table('vouchers')->count() == 0) {
            $vouchers = [
                ['code' => 'FLORES10', 'description' => 'Diskon 10% untuk semua rute Flores', 'type' => 'percentage', 'value' => 10, 'max_discount' => 100000, 'usage_limit' => 100, 'used_count' => 23, 'valid_from' => $now->toDateString(), 'valid_until' => $now->copy()->addMonths(3)->toDateString(), 'is_active' => 1],
                ['code' => 'ENDETRIP', 'description' => 'Diskon Rp50.000 untuk pemesanan dari Ende', 'type' => 'fixed', 'value' => 50000, 'max_discount' => null, 'usage_limit' => 50, 'used_count' => 12, 'valid_from' => $now->toDateString(), 'valid_until' => $now->copy()->addMonths(2)->toDateString(), 'is_active' => 1],
                ['code' => 'WELCOME', 'description' => 'Diskon 15% untuk pengguna baru', 'type' => 'percentage', 'value' => 15, 'max_discount' => 75000, 'usage_limit' => 200, 'used_count' => 45, 'valid_from' => $now->toDateString(), 'valid_until' => $now->copy()->addMonths(6)->toDateString(), 'is_active' => 1],
                ['code' => 'LIBURAN', 'description' => 'Diskon Rp100.000 untuk liburan akhir pekan', 'type' => 'fixed', 'value' => 100000, 'max_discount' => null, 'usage_limit' => 30, 'used_count' => 8, 'valid_from' => $now->copy()->addDays(7)->toDateString(), 'valid_until' => $now->copy()->addMonths(1)->toDateString(), 'is_active' => 1],
                ['code' => 'HEMAT25', 'description' => 'Diskon 25% untuk perjalanan jauh', 'type' => 'percentage', 'value' => 25, 'max_discount' => 200000, 'usage_limit' => 10, 'used_count' => 2, 'valid_from' => $now->toDateString(), 'valid_until' => $now->copy()->addDays(14)->toDateString(), 'is_active' => 1],
                ['code' => 'WISATA', 'description' => 'Promo lama - diskon Rp25.000', 'type' => 'fixed', 'value' => 25000, 'max_discount' => null, 'usage_limit' => 500, 'used_count' => 156, 'valid_from' => $now->copy()->subMonth()->toDateString(), 'valid_until' => $now->copy()->addMonths(12)->toDateString(), 'is_active' => 0],
            ];
            foreach ($vouchers as $v) {
                $v['created_at'] = $now;
                $v['updated_at'] = $now;
                DB::table('vouchers')->insert($v);
            }
            echo "  ✅ Vouchers: " . count($vouchers) . " inserted\n";
        }

        // ==================== CMS PAGES ====================
        if (DB::table('cms_pages')->count() == 0) {
            $pages = [
                [
                    'slug' => 'tentang-kami',
                    'title' => 'Tentang ASR GO',
                    'content' => '<h2>ASR GO</h2><p>ASR GO adalah layanan travel dan rental kendaraan terpercaya di Pulau Flores, NTT. Kami melayani rute antar kota, airport transfer, dan rental mobil dengan armada terbaik dan sopir profesional.</p><p>Berdiri sejak 2020, ASR GO telah melayani ribuan pelanggan dengan rute mencakup Ende, Maumere, Bajawa, Ruteng, Labuan Bajo, dan berbagai destinasi wisata di Flores.</p>',
                    'excerpt' => 'Layanan travel dan rental kendaraan terpercaya di Flores, NTT',
                    'type' => 'about',
                    'is_published' => 1,
                    'order' => 1,
                    'created_by' => $superAdminId,
                    'updated_by' => $superAdminId,
                    'published_at' => $now,
                ],
                [
                    'slug' => 'cara-booking',
                    'title' => 'Cara Booking',
                    'content' => '<h2>Cara Memesan Tiket Travel</h2><ol><li>Pilih layanan (Travel/Rental/Airport Transfer)</li><li>Pilih rute atau kendaraan yang diinginkan</li><li>Isi data pemesanan dan jumlah penumpang</li><li>Pilih metode pembayaran</li><li>Lakukan pembayaran</li><li>Dapatkan tiket elektronik dan nikmati perjalanan</li></ol>',
                    'excerpt' => 'Panduan lengkap cara memesan tiket travel dan rental',
                    'type' => 'faq',
                    'is_published' => 1,
                    'order' => 2,
                    'created_by' => $superAdminId,
                    'updated_by' => $superAdminId,
                    'published_at' => $now,
                ],
                [
                    'slug' => 'syarat-ketentuan',
                    'title' => 'Syarat & Ketentuan',
                    'content' => '<h2>Syarat & Ketentuan</h2><p>Dengan menggunakan layanan ASR GO, Anda menyetujui syarat dan ketentuan berikut:</p><ul><li>Pemesanan dianggap sah setelah pembayaran dikonfirmasi</li><li>Pembatalan dikenakan biaya 20% dari total harga</li><li>Penumpang wajib hadir 15 menit sebelum keberangkatan</li><li>Barang bawaan menjadi tanggung jawab penumpang</li></ul>',
                    'excerpt' => 'Syarat dan ketentuan penggunaan layanan ASR GO',
                    'type' => 'other',
                    'is_published' => 1,
                    'order' => 3,
                    'created_by' => $superAdminId,
                    'updated_by' => $superAdminId,
                    'published_at' => $now,
                ],
            ];
            foreach ($pages as $p) {
                $p['created_at'] = $now;
                $p['updated_at'] = $now;
                DB::table('cms_pages')->insert($p);
            }
            echo "  ✅ CMS Pages: " . count($pages) . " inserted\n";
        }

        // ==================== GPS DEVICES ====================
        if (DB::table('gps_devices')->count() == 0) {
            $devices = [
                ['device_id' => 'GPS-AV001', 'device_name' => 'Tracker Avanza Putih', 'device_type' => 'gps_tracker', 'armada_id' => 1, 'api_key' => (string) Str::uuid(), 'is_active' => 1, 'last_contact_at' => $now->copy()->subMinutes(rand(5, 60)), 'settings' => json_encode(['interval' => 30, 'alert_speed' => 80])],
                ['device_id' => 'GPS-IN002', 'device_name' => 'Tracker Innova Hitam', 'device_type' => 'gps_tracker', 'armada_id' => 2, 'api_key' => (string) Str::uuid(), 'is_active' => 1, 'last_contact_at' => $now->copy()->subMinutes(rand(5, 60)), 'settings' => json_encode(['interval' => 30, 'alert_speed' => 100])],
                ['device_id' => 'GPS-HI003', 'device_name' => 'Tracker Hiace', 'device_type' => 'gps_tracker', 'armada_id' => 3, 'api_key' => (string) Str::uuid(), 'is_active' => 0, 'last_contact_at' => $now->copy()->subDays(7), 'settings' => json_encode(['interval' => 60, 'alert_speed' => 80])],
                ['device_id' => 'GPS-BR004', 'device_name' => 'Tracker Brio', 'device_type' => 'gps_tracker', 'armada_id' => 4, 'api_key' => (string) Str::uuid(), 'is_active' => 1, 'last_contact_at' => $now->copy()->subMinutes(rand(5, 60)), 'settings' => json_encode(['interval' => 30, 'alert_speed' => 90])],
                ['device_id' => 'GPS-EL005', 'device_name' => 'Tracker Elf Cadangan', 'device_type' => 'gps_tracker', 'armada_id' => null, 'api_key' => (string) Str::uuid(), 'is_active' => 1, 'last_contact_at' => $now->copy()->subDays(3), 'settings' => json_encode(['interval' => 60, 'alert_speed' => 70])],
            ];
            foreach ($devices as $d) {
                $d['created_at'] = $now->copy()->subDays(rand(10, 90));
                $d['updated_at'] = $now;
                DB::table('gps_devices')->insert($d);
            }
            echo "  ✅ GPS Devices: " . count($devices) . " inserted\n";
        }

        // ==================== VEHICLES (for rental and travel FK) ====================
        $vehicleIds = [];
        if (DB::table('vehicles')->count() == 0) {
            $armadaList = DB::table('armadas')->get();
            $vehicleData = [];
            foreach ($armadaList as $armada) {
                $vid = (string) Str::uuid();
                $vehicleIds[] = $vid;
                DB::table('vehicles')->insert([
                    'id' => $vid,
                    'partner_id' => $superAdminId,
                    'plate_number' => $armada->plate_number,
                    'brand' => 'Toyota',
                    'model' => $armada->vehicle_type,
                    'year' => rand(2019, 2024),
                    'service_type' => 'travel',
                    'total_seats' => $armada->seat_capacity,
                    'daily_rate' => [300000, 350000, 500000, 750000][$armada->id % 4],
                    'color' => ['Putih', 'Hitam', 'Silver', 'Biru'][$armada->id % 4],
                    'vin' => 'VIN-' . strtoupper(Str::random(12)),
                    'registration_number' => 'REG-' . strtoupper(Str::random(8)),
                    'registration_expiry' => $now->copy()->addYears(rand(1, 3))->toDateString(),
                    'insurance_expiry' => $now->copy()->addYears(rand(1, 2))->toDateString(),
                    'tax_expiry' => $now->copy()->addYear()->toDateString(),
                    'status' => 'active',
                    'is_verified' => 1,
                    'average_rating' => round(3.5 + rand(0, 15) / 10, 1),
                    'company_id' => $companyId,
                    'created_at' => $now->copy()->subDays(rand(30, 90)),
                    'updated_at' => $now,
                ]);
            }
            echo "  ✅ Vehicles: " . count($vehicleIds) . " inserted\n";
        } else {
            $vehicleIds = DB::table('vehicles')->pluck('id')->toArray();
        }

        // ==================== TRAVEL BOOKINGS ====================
        $bookingMap = []; // booking_id => booking for review/refund linking
        if (DB::table('travel_bookings')->count() == 0) {
            $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
            $routeIds = DB::table('routes')->pluck('id')->toArray();

            for ($i = 1; $i <= 12; $i++) {
                $routeId = $routeIds[array_rand($routeIds)];
                $route = DB::table('routes')->find($routeId);
                $status = $statuses[$i % 4];
                $paymentStatus = 'unpaid';
                if ($status === 'confirmed' || $status === 'completed') {
                    $paymentStatus = 'paid';
                } elseif ($status === 'cancelled') {
                    $paymentStatus = 'refunded';
                }
                $passengers = rand(1, 4);
                $pricePerSeat = DB::table('travel_prices')->where('route_id', $routeId)->value('price_per_seat') ?? 150000;
                $totalPrice = $pricePerSeat * $passengers;
                $discount = 0;
                $finalPrice = $totalPrice;
                $bookingDate = $now->copy()->subDays(rand(1, 30));
                $bookingCode = 'TRV-' . strtoupper(Str::random(8));

                $scheduledDate = $bookingDate->format('Y-m-d');
                $departureTime = $scheduledDate . ' ' . ['08:00:00', '10:00:00', '13:00:00', '16:00:00', '19:00:00'][array_rand(['08:00:00', '10:00:00', '13:00:00', '16:00:00', '19:00:00'])];

                $bookingId = (string) Str::uuid();
                $bookingMap[$bookingId] = (object)[
                    'id' => $bookingId,
                    'user_id' => $customerIds[array_rand($customerIds)],
                    'total_price' => $totalPrice,
                    'final_price' => $finalPrice,
                    'status' => $status,
                    'payment_status' => $paymentStatus,
                    'booking_code' => $bookingCode,
                    'created_at' => $bookingDate,
                ];

                DB::table('travel_bookings')->insert([
                    'id' => $bookingId,
                    'user_id' => $customerIds[array_rand($customerIds)],
                    'route_id' => $routeId,
                    'vehicle_id' => count($vehicleIds) > 0 ? $vehicleIds[array_rand($vehicleIds)] : null,
                    'booking_code' => $bookingCode,
                    'passenger_count' => $passengers,
                    'total_price' => $totalPrice,
                    'discount' => $discount,
                    'final_price' => $finalPrice,
                    'passenger_details' => json_encode([['name' => 'Penumpang 1', 'phone' => '08123' . rand(100000, 999999)]]),
                    'status' => $status,
                    'payment_status' => $paymentStatus,
                    'departure_time' => $departureTime,
                    'arrival_time' => null,
                    'notes' => $i === 1 ? 'Penumpang minta antar jemput di hotel' : null,
                    'number_of_seats' => $passengers,
                    'scheduled_date' => $scheduledDate,
                    'assigned_armada_id' => rand(1, 4),
                    'company_id' => $companyId,
                    'qr_code_token' => (string) Str::uuid(),
                    'qr_code_status' => 'active',
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate,
                ]);
            }
            echo "  ✅ Travel Bookings: 12 inserted\n";
        } else {
            $existing = DB::table('travel_bookings')->get();
            foreach ($existing as $b) {
                $bookingMap[$b->id] = $b;
            }
        }

        // ==================== RENTAL BOOKINGS ====================
        $rentalBookingIds = [];
        if (DB::table('rental_bookings')->count() == 0) {
            $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
            $armadaList = DB::table('armadas')->get();

            for ($i = 1; $i <= 8; $i++) {
                $armada = $armadaList->count() > 0 ? $armadaList->random() : null;
                $status = $statuses[$i % 4];
                $days = rand(1, 5);
                $dailyRate = [250000, 350000, 500000, 750000][array_rand([0, 1, 2, 3])];
                $totalPrice = $dailyRate * $days;
                $discount = $totalPrice > 1000000 ? 50000 : 0;
                $finalPrice = $totalPrice - $discount;
                $bookingDate = $now->copy()->subDays(rand(1, 20));
                $startDate = $bookingDate->format('Y-m-d');
                $endDate = $bookingDate->copy()->addDays($days)->format('Y-m-d');
                $bookingCode = 'RNT-' . strtoupper(Str::random(8));

                // Get a valid vehicle ID
                $vehicleId = count($vehicleIds) > 0 ? $vehicleIds[array_rand($vehicleIds)] : null;
                if (!$vehicleId) continue;

                $rentalBookingId = (string) Str::uuid();
                $rentalBookingIds[] = $rentalBookingId;

                DB::table('rental_bookings')->insert([
                    'id' => $rentalBookingId,
                    'user_id' => $customerIds[array_rand($customerIds)],
                    'vehicle_id' => $vehicleId,
                    'booking_code' => $bookingCode,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'days' => $days,
                    'daily_rate' => $dailyRate,
                    'total_price' => $totalPrice,
                    'discount' => $discount,
                    'final_price' => $finalPrice,
                    'status' => $status,
                    'payment_status' => $status === 'completed' || $status === 'confirmed' ? 'paid' : 'unpaid',
                    'pickup_location' => ['Bandara Ende', 'Pelabuhan Ende', 'Kantor ASR GO', 'Hotel', 'Bandara Soa'][array_rand(['Bandara Ende', 'Pelabuhan Ende', 'Kantor ASR GO', 'Hotel', 'Bandara Soa'])],
                    'return_location' => ['Bandara Ende', 'Kantor ASR GO', 'Pelabuhan Ende'][array_rand(['Bandara Ende', 'Kantor ASR GO', 'Pelabuhan Ende'])],
                    'notes' => $i === 1 ? 'Mobil dibersihkan sebelum diserahkan' : null,
                    'company_id' => $companyId,
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate,
                ]);
            }
            echo "  ✅ Rental Bookings: " . count($rentalBookingIds) . " inserted\n";
        }

        // ==================== PAYMENTS ====================
        $paymentIdMap = []; // booking_id => payment_id
        if (DB::table('payments')->count() == 0) {
            $paymentMethods = ['credit_card', 'bank_transfer', 'cash', 'midtrans'];
            foreach ($bookingMap as $bkId => $booking) {
                $status = 'success';
                if ($booking->status === 'pending') {
                    $status = 'pending';
                } elseif ($booking->status === 'cancelled') {
                    $status = 'failed';
                }

                $paymentId = (string) Str::uuid();
                $paymentIdMap[$bkId] = $paymentId;

                DB::table('payments')->insert([
                    'id' => $paymentId,
                    'user_id' => $booking->user_id,
                    'booking_id' => $bkId,
                    'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
                    'amount' => $booking->final_price,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'status' => $status,
                    'midtrans_order_id' => 'MID-' . strtoupper(Str::random(10)),
                    'gateway_response' => null,
                    'description' => 'Pembayaran tiket ' . $booking->booking_code,
                    'reference_number' => 'REF-' . strtoupper(Str::random(8)),
                    'paid_at' => $status === 'success' ? $booking->created_at : null,
                    'company_id' => $companyId,
                    'created_at' => $booking->created_at,
                    'updated_at' => $booking->created_at,
                ]);
            }

            // Also create payments for rental bookings
            foreach ($rentalBookingIds as $rBkId) {
                $rBooking = DB::table('rental_bookings')->find($rBkId);
                if ($rBooking) {
                    $rPaymentId = (string) Str::uuid();
                    $paymentIdMap['rental-' . $rBkId] = $rPaymentId;
                    DB::table('payments')->insert([
                        'id' => $rPaymentId,
                        'user_id' => $rBooking->user_id,
                        'booking_id' => null,
                        'transaction_id' => 'TXN-RNT-' . strtoupper(Str::random(12)),
                        'amount' => $rBooking->final_price,
                        'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                        'status' => $rBooking->status === 'completed' || $rBooking->status === 'confirmed' ? 'success' : 'pending',
                        'midtrans_order_id' => 'MID-RNT-' . strtoupper(Str::random(10)),
                        'gateway_response' => null,
                        'description' => 'Pembayaran rental ' . $rBooking->booking_code,
                        'reference_number' => 'REF-RNT-' . strtoupper(Str::random(8)),
                        'paid_at' => $rBooking->status === 'completed' || $rBooking->status === 'confirmed' ? $rBooking->created_at : null,
                        'company_id' => $companyId,
                        'created_at' => $rBooking->created_at,
                        'updated_at' => $rBooking->created_at,
                    ]);
                }
            }
            echo "  ✅ Payments: " . (count($bookingMap) + count($rentalBookingIds)) . " inserted\n";
        } else {
            $existingPayments = DB::table('payments')->get();
            foreach ($existingPayments as $p) {
                if ($p->booking_id) {
                    $paymentIdMap[$p->booking_id] = $p->id;
                }
            }
        }

        // ==================== REFUNDS ====================
        if (DB::table('refunds')->count() == 0) {
            $cancelledBookings = DB::table('travel_bookings')->where('status', 'cancelled')->get();
            $refundStatuses = ['pending', 'approved', 'processed'];
            foreach ($cancelledBookings as $bk) {
                $paymentId = $paymentIdMap[$bk->id] ?? null;
                if (!$paymentId) continue;

                $refundStatus = $refundStatuses[array_rand($refundStatuses)];
                $approvedAt = $refundStatus === 'approved' || $refundStatus === 'processed' ? $now->copy()->subDays(rand(1, 3)) : null;
                $processedAt = $refundStatus === 'processed' ? $now->copy()->subDays(rand(0, 2)) : null;

                DB::table('refunds')->insert([
                    'payment_id' => $paymentId,
                    'user_id' => $bk->user_id,
                    'type' => 'travel',
                    'refundable_type' => 'App\Models\TravelBooking',
                    'refundable_id' => abs(crc32($bk->id)),
                    'amount' => $bk->total_price * 0.8,
                    'reason' => 'Pembatalan oleh pelanggan',
                    'status' => $refundStatus,
                    'rejection_reason' => null,
                    'approved_at' => $approvedAt,
                    'processed_at' => $processedAt,
                    'created_at' => $now->copy()->subDays(rand(1, 5)),
                    'updated_at' => $now,
                ]);
            }
            echo "  ✅ Refunds: " . $cancelledBookings->count() . " inserted\n";
        }

        // ==================== REVIEWS ====================
        if (DB::table('reviews')->count() == 0) {
            $completedBookings = DB::table('travel_bookings')->whereIn('status', ['completed', 'confirmed'])->get();
            $reviewTypes = ['cleanliness', 'comfort', 'driver', 'price', 'overall'];
            $comments = [
                'Pelayanan bagus, sopir ramah',
                'Tepat waktu, mobil bersih',
                'Recommended untuk traveling di Flores',
                'Perjalanan nyaman, AC dingin',
                'Harga terjangkau, pelayanan memuaskan',
                'Mantul banget, next order lagi',
                'Sopir profesional, jalur hafal',
                'Mobil mewah dan bersih, recommended!',
            ];
            foreach ($completedBookings as $bk) {
                DB::table('reviews')->insert([
                    'id' => (string) Str::uuid(),
                    'user_id' => $bk->user_id,
                    'booking_id' => $bk->id,
                    'rated_user_id' => $driverUserIds[array_rand($driverUserIds)],
                    'rating' => rand(3, 5),
                    'comment' => $comments[array_rand($comments)],
                    'review_type' => $reviewTypes[array_rand($reviewTypes)],
                    'is_verified' => rand(0, 1),
                    'created_at' => $now->copy()->subDays(rand(1, 15)),
                    'updated_at' => $now,
                ]);
            }
            echo "  ✅ Reviews: " . $completedBookings->count() . " inserted\n";
        }

        // ==================== AUDIT LOGS ====================
        if (DB::table('audit_logs')->count() == 0) {
            $actions = ['created', 'updated', 'deleted', 'login', 'booking_approved', 'booking_cancelled', 'payment_received', 'voucher_applied'];
            $models = ['App\Models\TravelBooking', 'App\Models\RentalBooking', 'App\Models\Payment', 'App\Models\User', 'App\Models\Voucher'];
            for ($i = 0; $i < 15; $i++) {
                DB::table('audit_logs')->insert([
                    'id' => (string) Str::uuid(),
                    'user_id' => [null, $superAdminId, $adminId, $customerIds[array_rand($customerIds)]][array_rand([0, 1, 1, 2])],
                    'action' => $actions[array_rand($actions)],
                    'model' => $models[array_rand($models)],
                    'model_id' => (string) rand(1, 50),
                    'old_values' => json_encode(['status' => 'pending']),
                    'new_values' => json_encode(['status' => 'confirmed']),
                    'ip_address' => '192.168.1.' . rand(10, 200),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'company_id' => $companyId,
                    'created_at' => $now->copy()->subHours(rand(1, 168)),
                    'updated_at' => $now->copy()->subHours(rand(1, 168)),
                ]);
            }
            echo "  ✅ Audit Logs: 15 inserted\n";
        }

        // ==================== REVENUE SHARINGS ====================
        if (DB::table('revenue_sharings')->count() == 0) {
            $mitraIds = DB::table('mitras')->pluck('id')->toArray();
            $paidTravelBookings = DB::table('travel_bookings')->where('payment_status', 'paid')->get();

            foreach ($paidTravelBookings as $bk) {
                $paymentId = $paymentIdMap[$bk->id] ?? null;
                if (!$paymentId) continue;

                $totalAmount = $bk->final_price;
                $adminPercentage = 30;
                $mitraPercentage = 50;
                $driverPercentage = 20;

                DB::table('revenue_sharings')->insert([
                    'booking_type' => 'App\Models\TravelBooking',
                    'booking_id' => abs(crc32($bk->id)),
                    'payment_id' => $paymentId,
                    'mitra_id' => $mitraIds[array_rand($mitraIds)],
                    'admin_amount' => $totalAmount * $adminPercentage / 100,
                    'mitra_amount' => $totalAmount * $mitraPercentage / 100,
                    'driver_amount' => $totalAmount * $driverPercentage / 100,
                    'admin_percentage' => $adminPercentage,
                    'mitra_percentage' => $mitraPercentage,
                    'driver_percentage' => $driverPercentage,
                    'status' => ['pending', 'paid'][array_rand(['pending', 'paid'])],
                    'paid_at' => null,
                    'company_id' => $companyId,
                    'created_at' => $bk->created_at,
                    'updated_at' => $now,
                ]);
            }
            $count = DB::table('revenue_sharings')->count();
            echo "  ✅ Revenue Sharings: $count inserted\n";
        }

        // ==================== VEHICLE MAINTENANCE LOGS ====================
        if (DB::table('vehicle_maintenance_logs')->count() == 0) {
            $armadas = DB::table('armadas')->get();
            $maintenanceTypes = ['oil_change', 'tire_rotation', 'brake_service', 'general_service', 'ac_service', 'engine_tune_up'];
            foreach ($armadas as $a) {
                $numLogs = rand(1, 2);
                for ($j = 0; $j < $numLogs; $j++) {
                    $cost = [200000, 350000, 500000, 750000, 1000000, 1500000][array_rand([0, 1, 2, 3, 4, 5])];
                    $maintenanceDate = $now->copy()->subDays(rand(1, 90));
                    DB::table('vehicle_maintenance_logs')->insert([
                        'armada_id' => $a->id,
                        'maintenance_type' => $maintenanceTypes[array_rand($maintenanceTypes)],
                        'description' => 'Servis rutin berkala',
                        'cost' => $cost,
                        'maintenance_date' => $maintenanceDate,
                        'scheduled_next_at' => $maintenanceDate->copy()->addMonths(3),
                        'status' => ['completed', 'completed', 'in_progress', 'scheduled'][rand(0, 3)],
                        'notes' => $j === 0 ? 'Ganti oli mesin' : 'Cek kondisi rem dan ban',
                        'created_at' => $maintenanceDate,
                        'updated_at' => $now,
                    ]);
                }
            }
            $count = DB::table('vehicle_maintenance_logs')->count();
            echo "  ✅ Maintenance Logs: $count inserted\n";
        }

        echo "\n✅ Demo data seeding complete!\n";
    }
}
