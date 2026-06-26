# ASR GO - Travel & Rental Management System

Aplikasi pemesanan travel dan rental mobil berbasis web dengan Laravel 13, sistem pembayaran Midtrans, dan revenue sharing otomatis.

---

## Tech Stack

- **Framework:** Laravel 13 (PHP 8.3)
- **Database:** MySQL 8.0
- **Frontend:** Tailwind CSS CDN (no Vite/build)
- **Payment:** Midtrans Snap
- **Auth:** Spatie Laravel Permission (roles)
- **Server:** Apache via Laragon (Windows)

---

## Fitur Lengkap

### 1. Halaman Publik (Guest)

| Halaman | Fitur |
|---------|-------|
| Home | Hero section, info travel & rental, tombol booking, testimoni, footer |
| Travel | Daftar rute dengan filter asal/tujuan/harga, pagination |
| Rental | Daftar harga rental dengan opsi sopir/tanpa sopir |
| Cek Harga | Kalkulator harga otomatis (pilih tujuan, layanan, sopir) |
| Tentang Kami | Profil perusahaan, visi misi |
| Kontak | WhatsApp, alamat, email, Google Maps embed |

### 2. Authentication

| Fitur | Keterangan |
|-------|------------|
| Login | Dengan role selection (admin/customer/driver/partner) |
| Register | Pilih role saat registrasi |
| Verifikasi Identitas | Upload KTP/SIM, status verified/unverified |
| Role-based Redirect | Auto redirect ke dashboard sesuai role |

### 3. Dashboard User (Customer)

| Fitur | Keterangan |
|-------|------------|
| Dashboard | Ringkasan booking, status pembayaran, riwayat |
| Booking Travel | Pilih rute, jumlah kursi, tanggal |
| Booking Rental | Dengan/tanpa sopir, tanggal, durasi |
| Pembayaran | Midtrans Snap integration |
| Riwayat Transaksi | Semua booking dengan status |
| Profil | Edit data, ganti password, verifikasi identitas |
| Notifikasi | Badge notifikasi, mark as read |
| Ticket & QR | Lihat tiket + QR code untuk checkin |

### 4. Dashboard Admin

| Fitur | Keterangan |
|-------|------------|
| Dashboard | Total transaksi, user, pendapatan, grafik |
| Manajemen User | Daftar user, verifikasi, nonaktifkan |
| Manajemen Mitra | CRUD mitra, payout, lihat earnings |
| Manajemen Driver | CRUD driver, approve, status tracking |
| Manajemen Armada | CRUD armada (plat, driver, kendaraan, status) |
| Manajemen Rute Travel | CRUD rute (asal, tujuan, jarak, harga) |
| Manajemen Harga Rental | CRUD harga rental (dengan/tanpa sopir) |
| Booking Travel | Detail, assign armada, update status (approve/complete/cancel) |
| Booking Rental | Detail, assign armada, update status |
| Manajemen Pembayaran | List, filter status, detail Midtrans ID |
| Revenue Sharing | Breakdown admin/mitra/sopir, filter, export CSV |
| Laporan | Travel, rental, pendapatan, revenue sharing |
| Export | PDF (invoice, ticket, manifest), Excel |
| Voucher | CRUD promo/diskon, customer apply saat checkout |
| Pengaturan Sistem | Persentase bagi hasil, konfigurasi Midtrans |

### 5. Dashboard Driver

| Fitur | Keterangan |
|-------|------------|
| Dashboard | Order aktif, total trips, saldo, status toggle |
| Order Masuk | List booking assigned, terima/tolak |
| Mulai Perjalanan | Update status departed, create trip tracking |
| Selesaikan Perjalanan | Update status completed, tambah saldo |
| Navigasi | Google Maps link ke tujuan |
| Earnings | Riwayat pendapatan, saldo, pending earnings |
| Trip History | Riwayat perjalanan yang diselesaikan |

### 6. Dashboard Partner (Mitra)

| Fitur | Keterangan |
|-------|------------|
| Dashboard | Total armada, driver, earnings, pending payout |
| Armada Saya | CRUD armada milik partner (plat, driver, status) |
| Driver Saya | CRUD driver milik partner |
| Revenue | Detail revenue sharing partner |
| Recent Transactions | List transaksi terbaru |

### 7. Sistem

| Fitur | Keterangan |
|-------|------------|
| Roles & Permissions | admin, customer, driver, partner (spatie) |
| Revenue Sharing | Auto split 30/50/20 (admin/mitra/driver) |
| Midtrans Payment | Snap token, callback handler, status check |
| Export PDF | Invoice, ticket, manifest (DomPDF) |
| Export Excel | Bookings, revenue, drivers (Laravel Excel) |
| Error Pages | 403, 404, 500, Maintenance |
| Notification | Per-user notification with unread badge |

---

## Struktur Role & Revenue Sharing

```
Booking → Payment Success → Revenue Sharing Auto Split:
  - Admin  : 30% (platform)
  - Mitra  : 50% (partner)
  - Driver : 20% (sopir)
```

---

## Database Tables

| Tabel | Keterangan |
|-------|------------|
| users | Semua user dengan role |
| companies | Multi-tenant (SaaS ready) |
| locations | Lokasi untuk rute |
| routes | Rute travel & rental |
| armadas | Kendaraan + driver |
| travel_bookings | Pemesanan travel |
| rental_bookings | Pemesanan rental |
| airport_transfer_bookings | Transfer bandara |
| payments | Record pembayaran Midtrans |
| revenue_sharings | Bagi hasil per booking |
| vouchers | Kode promo/diskon |
| notifications | Notifikasi per user |
| identity_verifications | Verifikasi KTP/SIM |
| reviews | Rating & review |
| audit_logs | Log aktivitas |
| settings | Pengaturan sistem |
| invoices | Invoice PDF |
| tickets | Tiket dengan QR |
| trip_trackings | Tracking perjalanan |
| vehicle_locations | GPS lokasi kendaraan |
| vehicle_maintenance_logs | Log maintenance armada |
| mitras | Data partner/mitra |
| drivers | Profil driver terpisah |
| travel_prices | Harga per rute |
| rental_prices | Harga rental per rute |
| travel_seats | Kursi per travel |
| booking_passengers | Data penumpang |
| cms_pages | Halaman statis (FAQ, dll) |

---

## Cara Menjalankan

### Prasyarat
- Laragon (Apache + MySQL) aktif
- PHP 8.3
- Composer
- Node 18 (opsional, CDN only)

### Setup

```bash
cd C:\laragon\www\asr-go

# Install dependencies
composer install
npm install

# Database (MySQL harus aktif dari Laragon CP)
php artisan migrate:fresh --seed

# Jalankan server
php artisan serve
```

### Akses
```
URL: http://asr-go.test
```

### Demo Accounts
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@asrgo.test | password |
| Customer | customer@asrgo.test | password |
| Driver | driver@asrgo.test | password |
| Partner | partner@asrgo.test | password |

---

## Routes Utama

```
/                           → Homepage
/public/travel              → Daftar travel
/public/rental              → Daftar rental
/public/price-calculator    → Cek harga
/public/about               → Tentang kami
/public/contact             → Kontak
/login                      → Login
/register                   → Register

/dashboard                  → Role-based dashboard
/bookings/travel            → Booking travel
/bookings/rental            → Booking rental
/payments/travel/{id}       → Bayar travel
/payments/rental/{id}       → Bayar rental
/tracking                   → Tracking map
/profile                    → Profil user
/notifications              → Notifikasi
/tickets/{booking}          → Tiket + QR

/admin                      → Admin dashboard
/admin/users                → Manajemen user
/admin/bookings             → Semua booking
/admin/bookings/{type}/{id} → Detail booking
/admin/payments             → Manajemen pembayaran
/admin/revenue-sharing      → Revenue sharing
/admin/vouchers             → Manajemen voucher
/admin/settings             → Pengaturan

/driver                     → Driver dashboard
/driver/orders              → Order aktif
/driver/earnings            → Pendapatan

/partner/dashboard          → Partner dashboard
/partner/armadas            → Armada saya
/partner/drivers            → Driver saya
/partner/revenue            → Revenue partner

/exports/bookings-pdf       → Export PDF bookings
/exports/revenue-excel      → Export Excel revenue
/exports/invoice/{id}       → Export invoice
/exports/ticket/{id}        → Export tiket
```

---

## API Endpoints

```
GET /api/voucher/validate?code=XXX&amount=100000
  → Validasi voucher saat checkout (auth required)
POST /payments/callback
  → Midtrans notification callback
GET /tickets/verify/{token}
  → Verifikasi tiket via QR
POST /tickets/checkin/{booking}
  → Checkin tiket
```

---

## File Structure

```
app/
├── Http/Controllers/
│   ├── Admin/AdminController.php
│   ├── Auth/ (Login, Register)
│   ├── BookingTravelController.php
│   ├── BookingRentalController.php
│   ├── DriverDashboardController.php
│   ├── PartnerController.php
│   ├── PaymentController.php
│   ├── NotificationController.php
│   ├── AnalyticsController.php
│   ├── ExportController.php
│   ├── FleetDashboardController.php
│   ├── TrackingDashboardController.php
│   └── ...
├── Models/
│   ├── User.php (HasRoles)
│   ├── TravelBooking.php
│   ├── RentalBooking.php
│   ├── Payment.php
│   ├── RevenueSharing.php
│   ├── Armada.php
│   ├── Mitra.php
│   ├── Voucher.php
│   ├── Notification.php
│   └── ...

resources/views/
├── layouts/app.blade.php (admin/driver/partner sidebar)
├── layouts/public.blade.php (guest)
├── admin/ (dashboard, bookings, booking-detail, payments, revenue-sharing, vouchers, users, drivers, partners, settings)
├── driver/ (dashboard, orders, earnings)
├── partner/ (dashboard, armadas, drivers, revenue)
├── customer/ (dashboard)
├── bookings/ (travel, rental, airport-transfer)
├── payments/ (travel-checkout, rental-checkout, success, error, pending)
├── notifications/ (index)
├── public/ (home, travel, rental, price-calculator, about, contact)
├── tracking/ (dashboard, map, vehicle-details, trip-tracking)
├── fleet/ (dashboard, vehicles, maintenance)
├── analytics/ (revenue, bookings, drivers)
├── errors/ (403, 404, 500, maintenance)
└── ...

routes/web.php (80+ routes)
```

---

## Customization

### Warna Brand
```css
--trvl-blue: #0064d2
--trvl-navy: #0d2147
--trvl-orange: #ff5e1c
```

### Revenue Sharing
Edit persentase di `app/Http/Controllers/PaymentService.php` atau di Settings admin.

### Midtrans
Konfigurasi di `.env`:
```
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

---

## License

ASR GO - CV. Izalhadji Travel
Built for skripsi & business use.
