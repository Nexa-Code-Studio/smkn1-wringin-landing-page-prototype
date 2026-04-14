<?php

use Illuminate\Http\Request;

// 1. Load Autoload
require __DIR__ . '/../vendor/autoload.php';

// 2. Boot Application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Konfigurasi Vercel (Wajib agar tidak error Read-Only)
$app->useStoragePath('/tmp');

// 4. Tangkap Error Asli (Agar tidak "Target class view does not exist")
try {
    $app->handleRequest(Request::capture());
} catch (\Exception $e) {
    echo "<h1>Fatal Error Detected:</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<p>File: " . $e->getFile() . " on line " . $e->getLine() . "</p>";
}
