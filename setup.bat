@echo off
REM ASR GO Setup Script for Windows

echo ======================================
echo ASR GO - Setup Script
echo ======================================
echo.

REM Check if .env exists
if not exist .env (
    echo [ERR] File .env tidak ditemukan. Silahkan copy .env.example ke .env
    pause
    exit /b 1
)

echo [OK] File .env ditemukan
echo.

REM Run composer install
echo [INFO] Installing composer dependencies...
call composer install
echo [OK] Composer dependencies installed
echo.

REM Run npm install
echo [INFO] Installing npm dependencies...
call npm install
echo [OK] NPM dependencies installed
echo.

REM Generate application key
echo [INFO] Generating application key...
call php artisan key:generate --force
echo [OK] Application key generated
echo.

REM Run migrations
echo [INFO] Running database migrations...
call php artisan migrate:fresh --seed --force
echo [OK] Database migrations completed
echo.

REM Build assets
echo [INFO] Building assets...
call npm run build
echo [OK] Assets built
echo.

echo ======================================
echo [SUCCESS] Setup Completed!
echo ======================================
echo.
echo Next steps:
echo 1. php artisan serve
echo 2. Open http://localhost:8000 in your browser
echo.
echo Demo Credentials:
echo Admin: admin@asrgo.com / password
echo Customer: customer@asrgo.com / password
echo Driver: driver@asrgo.com / password
echo Partner: partner@asrgo.com / password
echo.
pause
