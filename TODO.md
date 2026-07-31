# TODO

- [ ] Update role & permission mapping to match requirements (admin full, user booking+availability, partner revenue+utilization+finance reports, driver accept/start/complete)
- [ ] Fix role-name mismatch: demo users use `customer`, permission seeder uses `user`
- [ ] Adjust RolePermissionSeeder: admin sync all permissions
- [ ] Adjust partner permissions: remove global booking management; add utilization/location/finance-report permissions
- [ ] Adjust driver permissions: add permissions for receiving available trips/orders (if endpoints exist)
- [ ] Update Demo seeders if needed to align role names
- [ ] Run `php artisan db:seed --class=RolePermissionSeeder` and confirm permissions

