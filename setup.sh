#!/bin/bash

# ASR GO Setup Script
echo "======================================"
echo "ASR GO - Setup Script"
echo "======================================"
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "❌ File .env tidak ditemukan. Silahkan copy .env.example ke .env"
    exit 1
fi

echo "✅ File .env ditemukan"
echo ""

# Run composer install
echo "📦 Installing composer dependencies..."
composer install
echo "✅ Composer dependencies installed"
echo ""

# Run npm install
echo "📦 Installing npm dependencies..."
npm install
echo "✅ NPM dependencies installed"
echo ""

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate --force
echo "✅ Application key generated"
echo ""

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate:fresh --seed --force
echo "✅ Database migrations completed"
echo ""

# Build assets
echo "🎨 Building assets..."
npm run build
echo "✅ Assets built"
echo ""

echo "======================================"
echo "✅ Setup Completed Successfully!"
echo "======================================"
echo ""
echo "Next steps:"
echo "1. php artisan serve"
echo "2. Open http://localhost:8000 in your browser"
echo ""
echo "Demo Credentials:"
echo "Admin: admin@asrgo.com / password"
echo "Customer: customer@asrgo.com / password"
echo "Driver: driver@asrgo.com / password"
echo "Partner: partner@asrgo.com / password"
echo ""
