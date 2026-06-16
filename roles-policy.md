# Role & Permission Policy (4 Roles)

Dokumen ini menegaskan role yang harus bekerja seperti requirement:
- **admin**: bisa melihat & mengedit semuanya
- **user** (customer/guest terverifikasi): hanya memesan & melihat ketersediaan (seperti Traveloka)
- **mitra** (partner): melihat bagi hasil, utilisasi/lokasi mobil dipakai, & laporan keuangan
- **driver**: hanya menerima pesanan & mengelola start/complete trip

## Kondisi saat ini (berdasarkan kode yang dibaca)
1. `database/seeders/RolePermissionSeeder.php` mengatur role:
   - `super_admin`
   - `admin`
   - `partner`
   - `driver`
   - `user`
2. Routing:
   - `web.php` memakai `role:admin` untuk `/admin/*`
   - `web.php` memakai `role:driver` untuk `/driver/*`
3. Booking & payment:
   - `BookingTravelController` & `BookingRentalController` hanya membatasi data berdasarkan `role !== 'admin'` → user akan melihat booking miliknya
   - `PaymentController` mengandalkan `$this->authorize('view', $booking)`
   - driver start/complete pada `DriverDashboardController` untuk type `travel` dan `rental`

## Gap utama
- Seeder permissions `admin` belum otomatis `all permissions` (belum sync all).
- Role `user` dan `partner` tidak sepenuhnya merepresentasikan requirement (mis. mitra seharusnya lebih ke laporan & utilisasi, bukan manage booking global).
- Driver belum dipastikan permission untuk “lihat pesanan yang bisa diterima” (endpoint daftar pesanan tidak terlihat pada file yang dibaca).
- Demo user menggunakan role string `customer`, sedangkan seeder permissions membuat role bernama `user` → mismatch.

## Target akhir (setelah perubahan)
- `admin`: syncPermissions(Permission::all())
- `customer` harus dipetakan ke permission `user` (opsi: samakan role string, atau syncPermissions untuk role `customer`).
- `partner`: tambah permission khusus untuk utilisasi/lokasi mobil aktif & laporan payout/revenue share; kurangi manage booking global.
- `driver`: tambah permission untuk daftar pesanan/accept trip bila endpoint ada; jika tidak ada endpoint, minimal tetap bisa start/complete dari route yang sudah ada.

