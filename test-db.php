#!/usr/bin/env php
<?php

/**
 * ASR GO - Database Connection Test Script
 * 
 * Usage: php test-db.php
 */

// Load the framework
require __DIR__ . '/bootstrap/app.php';

// Get the database connection
try {
    $pdo = DB::connection()->getPdo();
    
    echo "✅ Database Connection Successful!\n";
    echo "────────────────────────────────────────────\n";
    
    // Show database info
    $dbInfo = $pdo->query("SELECT DATABASE() as db_name, VERSION() as version")->fetch(PDO::FETCH_ASSOC);
    echo "Database: " . $dbInfo['db_name'] . "\n";
    echo "MySQL Version: " . $dbInfo['version'] . "\n";
    
    // Count tables
    $tables = $pdo->query("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = DATABASE()")->fetch(PDO::FETCH_ASSOC);
    echo "Tables: " . $tables['count'] . "\n";
    
    // Show table list
    echo "\nTables:\n";
    $result = $pdo->query("SHOW TABLES");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        echo "  - " . $row[0] . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Database Connection Failed!\n";
    echo "────────────────────────────────────────────\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nPlease check:\n";
    echo "1. MySQL service is running\n";
    echo "2. Database credentials in .env file\n";
    echo "3. Database exists (asr_go)\n";
    echo "\nTo create database, run:\n";
    echo "  mysql -u root -p -e \"CREATE DATABASE asr_go;\"\n";
}
