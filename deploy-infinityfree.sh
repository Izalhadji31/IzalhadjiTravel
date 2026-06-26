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

# Determine zip method: prefer native zip, then 7z, then PowerShell
USE_ZIP_METHOD="zip"   # zip | 7z | powershell
if ! command -v zip &>/dev/null; then
    echo "[INFO] 'zip' command not found."
    # Check for 7-Zip
    if [[ -x "/c/Program Files/7-Zip/7z.exe" ]]; then
        echo "[INFO] Found 7-Zip — will use it for faster compression."
        USE_ZIP_METHOD="7z"
    elif command -v powershell.exe &>/dev/null; then
        echo "[INFO] Falling back to PowerShell Compress-Archive (may be slow with vendor/)..."
        USE_ZIP_METHOD="powershell"
    else
        echo "ERROR: Neither 'zip', 7-Zip, nor PowerShell is available."
        echo "  Install zip via: pacman -S zip  (MSYS2)"
        echo "  Or install 7-Zip from https://7-zip.org/"
        exit 1
    fi
fi

echo "[OK] Project directory: ${PROJECT_DIR}"
echo "[OK] vendor/ exists (will be included in zip)"
echo "[OK] Will use '${USE_ZIP_METHOD}' for creating zip archive"
echo ""

# ── Step 1: Ensure storage directory structure has .gitignore placeholders ────
echo "── Step 1: Verifying storage directory structure ─────────────"
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

# Check bootstrap/cache
if [[ ! -f "${PROJECT_DIR}/bootstrap/cache/.gitignore" ]]; then
    touch "${PROJECT_DIR}/bootstrap/cache/.gitignore"
    echo "  [FIX] Created bootstrap/cache/.gitignore"
fi

echo "[OK] Storage structure verified"
echo ""

# ── Step 2: Run composer optimize (optional but recommended) ─────────────────
echo "── Step 2: Optimizing Composer autoloader ────────────────────"
if command -v composer &>/dev/null; then
    composer dump-autoload --no-dev --optimize 2>/dev/null && echo "[OK] Autoloader optimized" || echo "[WARN] Could not optimize autoloader, continuing..."
else
    echo "[WARN] composer not found in PATH. Skipping autoloader optimization."
    echo "       Consider running: composer dump-autoload --no-dev --optimize"
fi
echo ""

# ── Step 3: Remove previous deploy zip ───────────────────────────────────────
echo "── Step 3: Preparing output zip ──────────────────────────────"
if [[ -f "${OUTPUT_ZIP}" ]]; then
    rm -f "${OUTPUT_ZIP}"
    echo "[OK] Removed previous deploy-infinityfree.zip"
fi
echo ""

# ── Step 4: Create deployment zip with exclusions ────────────────────────────
echo "── Step 4: Creating deployment zip ───────────────────────────"
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
echo "    ✗ storage/logs/*, storage/framework/cache/*, storage/framework/sessions/*"
echo "    ✗ storage/framework/views/* (will be regenerated)"
echo "    ✗ tests/ (development only)"
echo "    ✗ .phpunit.result.cache, phpunit.xml"
echo "    ✗ .phpstorm.meta.php, _ide_helper.php"
echo "    ✗ .DS_Store, Thumbs.db, *.log"
echo "    ✗ IDE config (.idea/, .vscode/, .cursor/)"
echo "    ✗ Previous deploy zip files, setup scripts, docs"
echo ""

cd "${PROJECT_DIR}"

if [[ "${USE_ZIP_METHOD}" == "7z" ]]; then
    # ══════════════════════════════════════════════════════════════════════════
    # 7-Zip method (fast, supports exclusions natively)
    # ══════════════════════════════════════════════════════════════════════════
    SEVEN_ZIP="/c/Program Files/7-Zip/7z.exe"

    echo "  Creating zip with 7-Zip..."
    "${SEVEN_ZIP}" a -tzip -mx=9 "${OUTPUT_ZIP}" . \
        -xr!".git" \
        -xr!"node_modules" \
        -xr!"tests" \
        -xr!".idea" \
        -xr!".vscode" \
        -xr!".cursor" \
        -xr!".zed" \
        -xr!".nova" \
        -xr!".phpunit.cache" \
        -xr!"_deploy_*" \
        -x!".env" \
        -x!".env.backup" \
        -x!".env.production" \
        -x!".phpunit.result.cache" \
        -x!".phpstorm.meta.php" \
        -x!"_ide_helper.php" \
        -x!".DS_Store" \
        -x!"Thumbs.db" \
        -x!"phpunit.xml" \
        -x!"auth.json" \
        -x!"Homestead.json" \
        -x!"Homestead.yaml" \
        -x!"deploy-infinityfree.zip" \
        -x!"setup.bat" \
        -x!"setup.sh" \
        -x!"test-db.php" \
        -x!"TODO.md" \
        -x!"TAMPILAN_BARU.md" \
        -x!"README.md" \
        -x!"Tracking_API_Collection.postman_collection.json" \
        -x!"vite.config.js" \
        -x!"package-lock.json" \
        -x!".npmrc" \
        -x!".editorconfig" \
        -x!".gitattributes" \
        -x!".gitignore" \
        -x!".phpactor.json" \
        -xr!".hermes-tmp*" \
        -x!"public\hot" \
        -xr!"public\build" \
        -x!"storage\*.key" \
        -x!"storage\pail" \
        -xr!"storage\logs" \
        -xr!"storage\framework\cache" \
        -xr!"storage\framework\sessions" \
        -xr!"storage\framework\views" \
        -x!"*.log"

elif [[ "${USE_ZIP_METHOD}" == "powershell" ]]; then
    # ══════════════════════════════════════════════════════════════════════════
    # PowerShell Compress-Archive fallback
    # Since Compress-Archive has no exclusion support, we use robocopy to
    # stage only the needed files, then zip the staging directory.
    # ══════════════════════════════════════════════════════════════════════════

    STAGING_DIR="${PROJECT_DIR}/_deploy_staging_${TIMESTAMP}"
    WIN_SRC="$(cygpath -w "${PROJECT_DIR}")"
    WIN_DST="$(cygpath -w "${STAGING_DIR}")"
    WIN_ZIP="$(cygpath -w "${OUTPUT_ZIP}")"
    PS_SCRIPT="${PROJECT_DIR}/_deploy_zip_helper.ps1"

    # Write a temporary PowerShell script to handle the robocopy + zip
    cat > "${PS_SCRIPT}" <<'PSEOF'
param([string]$Src, [string]$Dst, [string]$ZipOut)

# Directories to exclude
$excludeDirs = @(
    '.git', 'node_modules', 'tests',
    '.idea', '.vscode', '.cursor', '.zed', '.nova', '.phpunit.cache',
    '_deploy_staging_*', '.hermes-tmp*'
)

# Files to exclude
$excludeFiles = @(
    '.env', '.env.backup', '.env.production',
    '.phpunit.result.cache', '.phpstorm.meta.php', '_ide_helper.php',
    '.DS_Store', 'Thumbs.db', 'phpunit.xml',
    'auth.json', 'Homestead.json', 'Homestead.yaml',
    'deploy-infinityfree.zip', 'setup.bat', 'setup.sh', 'test-db.php',
    'TODO.md', 'TAMPILAN_BARU.md', 'README.md',
    'Tracking_API_Collection.postman_collection.json',
    'vite.config.js', 'package-lock.json',
    '.npmrc', '.editorconfig', '.gitattributes', '.gitignore',
    '.phpactor.json', '_deploy_zip_helper.ps1'
)

# Build robocopy exclusion arguments
$exDirArgs = $excludeDirs | ForEach-Object { '/XD', $_ }
$exFileArgs = $excludeFiles | ForEach-Object { '/XF', $_ }

Write-Host "  Staging files via robocopy..."
# Run robocopy (exit codes 0-7 are success, 8+ are errors)
robocopy $Src $Dst /E /NFL /NDL /NJH /NJS /NC /NS /NP @exDirArgs @exFileArgs | Out-Null
$rc = $LASTEXITCODE
if ($rc -ge 8) {
    Write-Host "ERROR: robocopy failed with exit code $rc"
    exit 1
}

# Delete contents of storage subdirs (keep dirs + .gitignore files)
$cleanDirs = @(
    'storage\logs',
    'storage\framework\cache',
    'storage\framework\sessions',
    'storage\framework\views'
)
foreach ($d in $cleanDirs) {
    $targetPath = Join-Path $Dst $d
    if (Test-Path $targetPath) {
        Get-ChildItem -Path $targetPath -Exclude '.gitignore' | Remove-Item -Recurse -Force -ErrorAction SilentlyContinue
    }
}

# Also exclude public/hot and public/build if they exist
$hotFile = Join-Path $Dst 'public\hot'
if (Test-Path $hotFile) { Remove-Item $hotFile -Force }
$buildDir = Join-Path $Dst 'public\build'
if (Test-Path $buildDir) { Remove-Item $buildDir -Recurse -Force }

Write-Host "  Creating zip archive via Compress-Archive..."
if (Test-Path $ZipOut) { Remove-Item $ZipOut -Force }
Compress-Archive -Path "$Dst\*" -DestinationPath $ZipOut -CompressionLevel Optimal

Write-Host "  Zip created successfully."
PSEOF

    echo "  Running PowerShell staging + zip script..."
    powershell.exe -NoProfile -ExecutionPolicy Bypass -File "$(cygpath -w "${PS_SCRIPT}")" \
        -Src "${WIN_SRC}" -Dst "${WIN_DST}" -ZipOut "${WIN_ZIP}"

    # Clean up
    echo "  Cleaning up staging directory..."
    rm -rf "${STAGING_DIR}" 2>/dev/null
    rm -f "${PS_SCRIPT}" 2>/dev/null

else
    # ══════════════════════════════════════════════════════════════════════════
    # Standard zip command (Linux / MSYS with zip installed)
    # ══════════════════════════════════════════════════════════════════════════

    zip -r -9 "${OUTPUT_ZIP}" . \
        -x ".env" \
        -x ".env.backup" \
        -x ".env.production" \
        -x ".git/*" \
        -x ".gitignore" \
        -x "node_modules/*" \
        -x "tests/*" \
        -x "phpunit.xml" \
        -x ".phpunit.result.cache" \
        -x ".phpstorm.meta.php" \
        -x "_ide_helper.php" \
        -x ".DS_Store" \
        -x "Thumbs.db" \
        -x ".idea/*" \
        -x ".vscode/*" \
        -x ".cursor/*" \
        -x ".zed/*" \
        -x ".nova/*" \
        -x ".phpactor.json" \
        -x ".phpunit.cache/*" \
        -x "deploy-infinityfree.zip" \
        -x "*.log" \
        -x "auth.json" \
        -x "Homestead.json" \
        -x "Homestead.yaml" \
        -x "setup.bat" \
        -x "setup.sh" \
        -x "test-db.php" \
        -x "TODO.md" \
        -x "TAMPILAN_BARU.md" \
        -x "Tracking_API_Collection.postman_collection.json" \
        -x "README.md" \
        -x "vite.config.js" \
        -x "package-lock.json" \
        -x ".npmrc" \
        -x ".editorconfig" \
        -x ".gitattributes" \
        -x "public/hot" \
        -x "public/build/*" \
        -x "storage/*.key" \
        -x "storage/pail" \
        -x "storage/logs/*" \
        -x "storage/framework/cache/*" \
        -x "storage/framework/sessions/*" \
        -x "storage/framework/views/*"
fi

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
