# Rental Booking Improvements - Traveloka Alignment

## Current Issues

### 1. Route-based vs City-based System
**Current:** Route-based (origin → destination)
**Traveloka:** City/region-based

**Problem:** ASR GO mengharuskan user memilih rute spesifik, sedangkan Traveloka membiarkan user memilih kota dan menentukan destinasi mereka sendiri.

**Solution:**
- Ubah system dari route-based ke city-based
- Tambah `pickup_city` dan `dropoff_city` fields
- Biarkan user memilih destinasi mereka secara bebas

### 2. Missing Time Selection
**Current:** Hanya tanggal (start_date, end_date)
**Traveloka:** Tanggal DAN waktu (start_date, start_time, end_date, end_time)

**Problem:** User tidak bisa memilih waktu pickup/return spesifik.

**Solution:**
- Tambah `start_time` dan `end_time` fields
- Update validation untuk memastikan waktu valid
- Hitung durasi berdasarkan datetime, bukan hanya hari

### 3. No Pickup/Drop-off Locations
**Current:** Tidak ada lokasi spesifik
**Traveloka:** Pickup dan drop-off locations spesifik

**Problem:** Tidak ada informasi di mana user akan pickup dan return mobil.

**Solution:**
- Tambah `pickup_location` dan `dropoff_location` fields
- Tambah `pickup_address` dan `dropoff_address` untuk detail
- Implement geocoding untuk validasi lokasi

### 4. No Car Type Selection
**Current:** Hanya berdasarkan rute
**Traveloka:** Pilih tipe mobil (Sedan, SUV, MPV, Luxury, dll)

**Problem:** User tidak bisa memilih tipe mobil yang diinginkan.

**Solution:**
- Tambah `vehicle_type` table (Sedan, SUV, MPV, Luxury, Van, dll)
- Tambah relationship ke vehicle types
- Update pricing per vehicle type
- Tampilkan filter vehicle type di search

### 5. No Provider Comparison
**Current:** Armada di-assign oleh admin
**Traveloka:** User bisa memilih provider dari berbagai opsi

**Problem:** User tidak bisa membandingkan harga dan rating antar provider.

**Solution:**
- Tampilkan list armada/provider yang available
- Tampilkan harga, rating, dan review
- Biarkan user memilih armada/provider
- Sort by price, rating, distance

### 6. No Special Requests
**Current:** Tidak ada opsi request tambahan
**Traveloka:** Special requests (child seat, GPS, additional driver, dll)

**Problem:** User tidak bisa request fasilitas tambahan.

**Solution:**
- Tambah `special_requests` field (text or JSON)
- Tambah `addons` table untuk opsi berbayar
- Implement pricing untuk addons

### 7. No Book for Others
**Current:** Hanya booking untuk diri sendiri
**Traveloka:** Bisa booking untuk orang lain

**Problem:** User tidak bisa booking mobil untuk orang lain/keluarga.

**Solution:**
- Tambah opsi "Book for someone else"
- Tambah fields: `guest_name`, `guest_phone`, `guest_email`
- Update payment flow untuk guest booking

### 8. No E-Voucher System
**Current:** Konfirmasi sederhana
**Traveloka:** E-voucher dengan QR code dan detail lengkap

**Problem:** Tidak ada voucher yang bisa ditunjukkan ke provider.

**Solution:**
- Generate e-voucher dengan unique QR code
- Tampilkan semua booking details di voucher
- Kirim voucher via email
- Implement voucher validation di pickup

### 9. No Installment Payment
**Current:** Full payment
**Traveloka:** Cicilan 1-12 bulan

**Problem:** User tidak bisa bayar dengan cicilan.

**Solution:**
- Integrasikan dengan Midtrans installment
- Tambah opsi cicilan di payment flow
- Update pricing untuk display cicilan

### 10. No Same-day Booking Logic
**Current:** Booking hari H tanpa restriction
**Traveloka:** Same-day booking dengan minimum 12 jam

**Problem:** Booking hari H bisa menyebabkan scheduling issues.

**Solution:**
- Tambah validation untuk same-day booking
- Minimum 12 jam sebelum pickup time
- Tampilkan warning jika booking mendekati pickup time

## Database Schema Changes Needed

### Table: rental_bookings
```sql
- ADD pickup_city (string)
- ADD dropoff_city (string)
- ADD start_time (time)
- ADD end_time (time)
- ADD pickup_location (string)
- ADD dropoff_location (string)
- ADD pickup_address (text)
- ADD dropoff_address (text)
- ADD pickup_lat (decimal)
- ADD pickup_lng (decimal)
- ADD dropoff_lat (decimal)
- ADD dropoff_lng (decimal)
- ADD vehicle_type_id (uuid)
- ADD special_requests (text/json)
- ADD is_for_guest (boolean)
- ADD guest_name (string)
- ADD guest_phone (string)
- ADD guest_email (string)
- ADD voucher_code (string)
- ADD installment_months (integer, nullable)
- ADD pickup_instructions (text)
```

### New Table: vehicle_types
```sql
- id (uuid)
- name (string) - Sedan, SUV, MPV, Luxury, Van, etc.
- capacity (integer) - max passengers
- base_price_multiplier (decimal) - pricing multiplier
- icon (string)
- description (text)
- is_active (boolean)
```

### New Table: rental_addons
```sql
- id (uuid)
- name (string) - Child Seat, GPS, etc.
- price_per_day (decimal)
- is_active (boolean)
```

### New Table: rental_booking_addons
```sql
- id (uuid)
- rental_booking_id (uuid)
- rental_addon_id (uuid)
- quantity (integer)
- total_price (decimal)
```

## Implementation Priority

### Phase 1: Core Booking Flow (High Priority)
1. ✅ Add time selection (start_time, end_time)
2. ✅ Add pickup/drop-off locations
3. ✅ Change from route-based to city-based
4. ✅ Add vehicle type selection
5. ✅ Update pricing calculation

### Phase 2: Provider Experience (Medium Priority)
6. ✅ Show available armadas/providers
7. ✅ Add provider comparison
8. ✅ Add ratings and reviews display
9. ✅ Allow user to select provider

### Phase 3: Enhanced Features (Medium Priority)
10. ✅ Add special requests
11. ✅ Add book for others
12. ✅ Add e-voucher system
13. ✅ Add same-day booking restrictions

### Phase 4: Payment Enhancements (Low Priority)
14. ✅ Add installment payment option
15. ✅ Add payment plan selection
16. ✅ Update payment flow

## Updated Booking Flow

### Current Flow:
1. Select route → Select date → Choose with/without driver → Select regency count → Book

### Traveloka-style Flow:
1. Select city/region → Select date & time → Choose vehicle type → Compare providers → Select provider → Add addons → Special requests → Pickup/drop-off locations → Guest info (if needed) → Payment → E-voucher

## Frontend Changes Needed

### New Views Required:
1. `rental-search.blade.php` - Search form with city, date, time
2. `rental-results.blade.php` - Show available vehicles with comparison
3. `rental-vehicle-detail.blade.php` - Vehicle details with reviews
4. `rental-addons.blade.php` - Select addons and special requests
5. `rental-guest.blade.php` - Guest information form
6. `rental-locations.blade.php` - Pickup/drop-off location selection
7. `rental-voucher.blade.php` - E-voucher display

### Updated Views:
1. `rental-create.blade.php` - Complete overhaul to new flow
2. `rental-show.blade.php` - Add voucher display
3. `rental-payment.blade.php` - Add installment options

## API Changes Needed

### New Endpoints:
- `GET /api/rental/cities` - List available cities
- `GET /api/rental/vehicle-types` - List vehicle types
- `GET /api/rental/search` - Search available vehicles
- `GET /api/rental/providers/{route_id}` - List providers for route
- `GET /api/rental/addons` - List available addons
- `POST /api/rental/calculate-price` - Calculate price with addons
- `POST /api/rental/generate-voucher` - Generate e-voucher
- `GET /api/rental/voucher/{code}` - Validate voucher

### Updated Endpoints:
- `POST /api/rental/bookings` - Updated with new fields
- `PUT /api/rental/bookings/{id}` - Update with new options

## Migration Plan

### Step 1: Database Migration
1. Create migration for new fields
2. Create vehicle_types table
3. Create rental_addons table
4. Update rental_bookings table
5. Run migration

### Step 2: Backend Updates
1. Update RentalBooking model
2. Update BookingRentalController
3. Add new controller methods
4. Update pricing calculation
5. Add voucher generation

### Step 3: Frontend Updates
1. Create new views
2. Update existing views
3. Add JavaScript for dynamic pricing
4. Add map integration for locations
5. Update styling

### Step 4: Testing
1. Test new booking flow
2. Test pricing calculation
3. Test voucher generation
4. Test payment flow
5. Test edge cases

## Estimated Timeline

- Phase 1: 3-5 days
- Phase 2: 2-3 days
- Phase 3: 2-3 days
- Phase 4: 1-2 days

**Total: 8-13 days** for complete Traveloka-style rental booking system

## Recommendations

### Immediate Actions:
1. Start with Phase 1 (Core Booking Flow) - ini yang paling penting
2. Focus on user experience alignment dengan Traveloka
3. Implement proper validation untuk semua new fields
4. Add comprehensive error handling

### Future Enhancements:
1. Add real-time vehicle availability
2. Implement dynamic pricing based on demand
3. Add loyalty program for frequent renters
4. Implement mobile-optimized booking flow
5. Add integration dengan ride-hailing apps
