#!/usr/bin/env bash
# =============================================================================
# deploy-infinityfree.sh
# Deployment helper for ASR-GO Laravel project → InfinityFree hosting
#
# IMPORTANT NOTES FOR INFINITYFREE:
#   - InfinityFree free plans do NOT support SSH access.
#   - You MUST upload files via FTP or the online File Manager.
#   - You MUST create your MySQL database via the InfinityFree control panel
#     (MySQL Databases section), then update your .env on the server.
#   - Composer is NOT available via SSH. This script includes vendor/ in the
#     zip because you need to run "composer install --no-dev --optimize-autoloader"
#     LOCALLY before running this script, then upload vendor/ along with the app.
#   - After uploading, rename .env.example → .env on the server and fill in
#     your InfinityFree database credentials.
#   - Run "php artisan key:generate" and "php artisan migrate" via the
#     InfinityFree control panel's terminal/composer tool, or by temporarily
#     adding a route that runs these commands.
#
# Usage (from project root on MSYS / Git Bash):
#   bash deploy-infinityfree.sh
#
# Output:
#   deploy-infinityfree.zip  — ready for FTP / File Manager upload
# =============================================================================

set -euo pipefail

# ── Configuration ─────────────────────────────────────────────────────────────
PROJECT_DIR="$(cd "$(dirname "$0")" && pwd)"
OUTPUT_ZIP="${PROJECT_DIR}/deploy-infinityfree.zip"
TIMESTAMP="$(date +%Y%m%d_%H%M%S)"

# ── Pre-flight checks ────────────────────────────────────────────────────────
echo "============================================"
echo "  ASR-GO → InfinityFree Deployment Helper"
echo "============================================"
echo ""

# Make sure we're in the project directory
if [[ ! -f "${PROJECT_DIR}/artisan" ]]; then
    echo "ERROR: artisan not found. Run this script from the project root."
    exit 1
fi

# Verify vendor/ exists (required since InfinityFree has no SSH)
if [[ ! -d "${PROJECT_DIR}/vendor" ]]; then
    echo "ERROR: vendor/ directory not found."
    echo "  Since InfinityFree has no SSH, you MUST install dependencies locally first:"
    echo "    composer install --no-dev --optimize-autoloader"
    echo "  Then re-run this script."
    exit 1
fi

# Verify zip command is available
if ! command -v zip &>/dev/null; then
    echo "ERROR: 'zip' command not found."
    echo "  Installing zip..."
    if command -v pacman &>/dev/null; then
        pacman -S --noconfirm zip 2>/dev/null && echo "[OK] zip installed via pacman" || { echo "ERROR: Failed to install zip via pacman."; exit 1; }
    elif command -v apt-get &>/dev/null; then
        apt-get install -y zip 2>/dev/null && echo "[OK] zip installed via apt" || { echo "ERROR: Failed to install zip via apt."; exit 1; }
    else
        echo "  Could not auto-install zip. Falling back to PowerShell Compress-Archive..."
        USE_POWERSHELL_ZIP=1
    fi
fi

# Determine zip method
USE_POWERSHELL_ZIP=${USE_POWERSHELL_ZIP:-0}

echo "[OK] Project directory: ${PROJECT_DIR}"
echo "[OK] vendor/ exists (will be included in zip)"
echo ""

# ── Step 1: Run composer optimize (optional but recommended) ─────────────────
echo "── Step 1: Optimizing Composer autoloader ────────────────────"
if command -v composer &>/dev/null; then
    composer dump-autoload --no-dev --optimize 2>/dev/null && echo "[OK] Autoloader optimized" || echo "[WARN] Could not optimize autoloader, continuing..."
else
    echo "[WARN] composer not found in PATH. Skipping autoloader optimization."
    echo "       Consider running: composer dump-autoload --no-dev --optimize"
fi
echo ""

# ── Step 2: Remove previous deploy zip ────────────────────────────────────────
echo "── Step 2: Preparing output zip ──────────────────────────────"
if [[ -f "${OUTPUT_ZIP}" ]]; then
    rm -f "${OUTPUT_ZIP}"
    echo "[OK] Removed previous deploy-infinityfree.zip"
fi
echo ""

# ── Step 3: Create deployment zip with exclusions ────────────────────────────
echo "── Step 3: Creating deployment zip ───────────────────────────"
echo "  Including:"
echo "    ✓ app/, bootstrap/, config/, database/, public/, resources/"
echo "    ✓ routes/, storage/ (structure only), vendor/"
echo "    ✓ artisan, composer.json, composer.lock, package.json"
echo "    ✓ .env.example (rename to .env on the server)"
echo ""
echo "  Excluding:"
echo "    ✗ .env (contains local secrets)"
echo "    ✗ .git/ (version control)"
echo "    ✗ node_modules/ (not needed on server)"
echo "    ✗ storage/logs/, storage/framework/cache/, storage/framework/sessions/"
echo "    ✗ storage/framework/views/ (will be regenerated)"
echo "    ✗ tests/ (development only)"
echo "    ✗ .phpunit.result.cache, phpunit.xml"
echo "    ✗ .phpstorm.meta.php, _ide_helper.php"
echo "    ✗ .DS_Store, Thumbs.db"
echo "    ✗ IDE config (.idea/, .vscode/, .cursor/)"
echo "    ✗ Previous deploy zip files"
echo ""

cd "${PROJECT_DIR}"

# Build the exclusion list for zip
ZIP_EXCLUDES=(
    ".env"
    ".env.backup"
    ".env.production"
    ".git/*"
    ".gitignore"
    "node_modules/*"
    "tests/*"
    "phpunit.xml"
    ".phpunit.result.cache"
    ".phpstorm.meta.php"
    "_ide_helper.php"
    ".DS_Store"
    "Thumbs.db"
    ".idea/*"
    ".vscode/*"
    ".cursor/*"
    ".zed/*"
    ".nova/*"
    ".phpactor.json"
    ".phpunit.cache/*"
    "deploy-infinityfree.zip"
    "*.log"
    "auth.json"
    "Homestead.json"
    "Homestead.yaml"
    "setup.bat"
    "setup.sh"
    "test-db.php"
    "TODO.md"
    "TAMPILAN_BARU.md"
    "Tracking_API_Collection.postman_collection.json"
    "README.md"
    "vite.config.js"
    "package-lock.json"
    ".npmrc"
    ".editorconfig"
    ".gitattributes"
    "public/hot"
    "public/build/*"
    "storage/*.key"
    "storage/pail"
)

# Build the -x arguments
EXCLUDE_ARGS=()
for pattern in "${ZIP_EXCLUDES[@]}"; do
    EXCLUDE_ARGS+=("-x" "${pattern}")
done

# Create the zip
# Using -r for recursive, -9 for max compression
zip -r -9 "${OUTPUT_ZIP}" . \
    "${EXCLUDE_ARGS[@]}" \
    -x "storage/logs/*" \
    -x "storage/framework/cache/*" \
    -x "storage/framework/sessions/*" \
    -x "storage/framework/views/*"

if [[ ! -f "${OUTPUT_ZIP}" ]]; then
    echo ""
    echo "ERROR: Failed to create deployment zip."
    exit 1
fi

ZIP_SIZE=$(du -h "${OUTPUT_ZIP}" | cut -f1)
echo ""
echo "[OK] Created: ${OUTPUT_ZIP}"
echo "[OK] Size: ${ZIP_SIZE}"
echo ""

# ── Step 4: Ensure storage structure placeholder files exist ──────────────────
echo "── Step 4: Verifying storage directory structure ─────────────"
# The zip should include .gitignore files that keep empty dirs tracked.
# Storage subdirectories are needed by Laravel but should be empty of user data.
STORAGE_DIRS=(
    "storage/app/public"
    "storage/app/private"
    "storage/framework/cache"
    "storage/framework/sessions"
    "storage/framework/views"
    "storage/logs"
)

for dir in "${STORAGE_DIRS[@]}"; do
    FULL_PATH="${PROJECT_DIR}/${dir}"
    if [[ -d "${FULL_PATH}" ]]; then
        # Ensure .gitignore exists so the directory is included in zip
        if [[ ! -f "${FULL_PATH}/.gitignore" ]]; then
            touch "${FULL_PATH}/.gitignore"
            echo "  [FIX] Created ${dir}/.gitignore (keeps empty dir in zip)"
        fi
    else
        mkdir -p "${FULL_PATH}"
        touch "${FULL_PATH}/.gitignore"
        echo "  [FIX] Created ${dir}/.gitignore"
    fi
done

# Check if bootstrap/cache exists and has .gitignore
if [[ ! -f "${PROJECT_DIR}/bootstrap/cache/.gitignore" ]]; then
    touch "${PROJECT_DIR}/bootstrap/cache/.gitignore"
    echo "  [FIX] Created bootstrap/cache/.gitignore"
fi

echo "[OK] Storage structure verified"
echo ""

# ── Re-create zip if we added missing .gitignore files ────────────────────────
if [[ -n "$(find "${PROJECT_DIR}/storage" -name '.gitignore' -newer "${OUTPUT_ZIP}" 2>/dev/null)" ]]; then
    echo "  Re-creating zip with updated .gitignore files..."
    rm -f "${OUTPUT_ZIP}"
    zip -r -9 "${OUTPUT_ZIP}" . \
        "${EXCLUDE_ARGS[@]}" \
        -x "storage/logs/*" \
        -x "storage/framework/cache/*" \
        -x "storage/framework/sessions/*" \
        -x "storage/framework/views/*"
    ZIP_SIZE=$(du -h "${OUTPUT_ZIP}" | cut -f1)
    echo "[OK] Updated zip size: ${ZIP_SIZE}"
    echo ""
fi

# ── Summary & Post-deployment Instructions ────────────────────────────────────
echo "============================================"
echo "  DEPLOYMENT ZIP READY"
echo "============================================"
echo ""
echo "  File: ${OUTPUT_ZIP}"
echo "  Size: ${ZIP_SIZE}"
echo ""
echo "── POST-DEPLOYMENT STEPS ON INFINITYFREE ────────────────────"
echo ""
echo "  1. UPLOAD THE ZIP"
echo "     - Log into InfinityFree control panel"
echo "     - Use the Online File Manager or FTP (FileZilla)"
echo "     - Upload deploy-infinityfree.zip to htdocs/ root"
echo "     - Extract the zip using the File Manager's extract tool"
echo "     - OR extract locally and upload files individually via FTP"
echo ""
echo "  2. CREATE THE DATABASE"
echo "     - InfinityFree Control Panel → MySQL Databases"
echo "     - Create a new database and note the credentials:"
echo "       • DB_HOST (usually sqlXXX.infinityfree.com)"
echo "       • DB_DATABASE"
echo "       • DB_USERNAME"
echo "       • DB_PASSWORD"
echo ""
echo "  3. CONFIGURE .ENV"
echo "     - Copy .env.example → .env on the server"
echo "     - Update these values:"
echo "       APP_URL=https://yourdomain.com"
echo "       DB_HOST=sqlXXX.infinityfree.com"
echo "       DB_DATABASE=if0_XXXXXXX_dbname"
echo "       DB_USERNAME=if0_XXXXXXX"
echo "       DB_PASSWORD=your_password"
echo ""
echo "  4. GENERATE APP KEY & RUN MIGRATIONS"
echo "     Option A: If InfinityFree provides a 'Composer' or 'PHP Console' tool"
echo "       php artisan key:generate"
echo "       php artisan migrate --force"
echo ""
echo "     Option B: Temporarily add this to routes/web.php:"
echo "       Route::get('/deploy-setup', function () {"
echo "         Artisan::call('key:generate');"
echo "         Artisan::call('migrate', ['--force' => true]);"
echo "         return 'Setup complete! Remove this route now.';"
echo "       });"
echo "     Then visit https://yourdomain.com/deploy-setup ONCE"
echo "     ⚠️  REMOVE THIS ROUTE IMMEDIATELY AFTER!"
echo ""
echo "  5. SET FILE PERMISSIONS (via File Manager or FTP)"
echo "     - storage/          → 755 (or 777 if 755 doesn't work)"
echo "     - bootstrap/cache/  → 755 (or 777)"
echo "     - storage/logs/     → 755 (or 777)"
echo ""
echo "  6. VERIFY"
echo "     - Visit your site URL and confirm it loads"
echo "     - Check that login/registration works"
echo "     - Check that database queries work"
echo ""
echo "── IMPORTANT REMINDERS ──────────────────────────────────────"
echo "  • InfinityFree has a 5MB per-file upload limit on free plans"
echo "    → If zip upload fails, extract locally and upload files via FTP"
echo "  • InfinityFree has daily hit limits — monitor usage"
echo "  • The vendor/ directory is included (no SSH/composer on server)"
echo "  • Do NOT upload .env with real credentials via unsecured FTP"
echo "    → Configure .env directly in the File Manager after upload"
echo ""
echo "============================================"
echo ""

# ── Alternative: PowerShell fallback ──────────────────────────────────────────
# If zip is unavailable, you can create the archive using PowerShell instead.
# Run this in PowerShell (not bash):
#
# $source = "C:\laragon\www\asr-go"
# $dest   = "C:\laragon\www\asr-go\deploy-infinityfree.zip"
# $exclude = @('.env','.git','node_modules','tests','phpunit.xml',
#              '.phpunit.result.cache','.DS_Store','Thumbs.db')
# Get-ChildItem -Path $source -Exclude $exclude |
#   Compress-Archive -DestinationPath $dest -Force
