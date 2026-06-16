sa# COMMIT GUIDE (Role/Permission Changes)

Gunakan 1 commit per kategori perubahan.

## Rekomendasi tipe commit
- `fix(auth/roles): ...`
- `chore(db): ...`
- `refactor(roles): ...`

## Format message (contoh)
- `fix(roles): sync admin to all permissions`
- `fix(roles): align demo role name customer <-> user permission role`
- `chore(db): adjust partner permissions for revenue & utilization only`
- `chore(db): adjust driver permissions for order acceptance`

## Checklist sebelum commit
- Pastikan role string di:
  - `database/seeders/IdempotentDemoUsersSeeder.php`
  - `database/seeders/DemoMitraSeeder.php`
  - `database/seeders/DemoDriversSeeder.php`
  - `database/seeders/RolePermissionSeeder.php`
  sinkron.
- Jika mengubah permission list, jalankan seeder permission dan pastikan tidak ada permission yang hilang untuk endpoint yang dipakai.

