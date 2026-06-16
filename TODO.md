# Task TODO - Fix missing `sessions` table

## Plan steps
- [ ] 1) Confirm session driver and table name from `config/session.php`.
- [ ] 2) Verify whether a `create_sessions_table` migration exists in `database/migrations`.
- [x] 3) If missing, create the Laravel sessions migration via `php artisan session:table`.
- [x] 4) Run migrations: `php artisan migrate`.
- [ ] 5) Re-test the request that triggers `SQLSTATE[42S02]` to confirm `sessions` exists.

- [ ] 6) (Optional) If DB sessions are not desired, change `SESSION_DRIVER` to `file` and clear config/cache.

