<?php

use Illuminate\Http\Request;

// Ensure SQLite database exists in a writable directory (Vercel /tmp)
$dbPath = '/tmp/database.sqlite';
$lockPath = '/tmp/db.lock';

if (!file_exists($dbPath)) {
    // Open lock file to prevent race conditions from concurrent cold-start requests
    $lockFile = fopen($lockPath, 'c+');
    if ($lockFile && flock($lockFile, LOCK_EX)) {
        // Double check database existence after acquiring lock
        if (!file_exists($dbPath)) {
            try {
                // Create the empty sqlite database file
                touch($dbPath);

                // Define LARAVEL_START if not already defined
                if (!defined('LARAVEL_START')) {
                    define('LARAVEL_START', microtime(true));
                }

                // Register the Composer autoloader
                require __DIR__ . '/../vendor/autoload.php';

                // Bootstrap Laravel
                $app = require_once __DIR__ . '/../bootstrap/app.php';

                // Resolve console kernel to execute artisan commands
                $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

                // Run migration and seed with force flag
                $kernel->call('migrate', ['--force' => true]);
                $kernel->call('db:seed', ['--force' => true]);

                // Handle the request directly using the booted application
                $app->handleRequest(Request::capture());

                // Release lock, close, and exit
                flock($lockFile, LOCK_UN);
                fclose($lockFile);
                exit;
            } catch (\Exception $e) {
                // Log the exception to stderr/error log
                error_log("Database auto-initialization failed: " . $e->getMessage());

                // Cleanup database file so the next request tries again
                if (file_exists($dbPath)) {
                    unlink($dbPath);
                }

                flock($lockFile, LOCK_UN);
                fclose($lockFile);
                throw $e;
            }
        }
        flock($lockFile, LOCK_UN);
        fclose($lockFile);
    }
}

// Forward requests to Laravel's public/index.php
require __DIR__ . '/../public/index.php';
