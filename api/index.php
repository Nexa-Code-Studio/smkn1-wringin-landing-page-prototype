<?php

use Illuminate\Http\Request;

// 1. Pastikan Autoload ada
$autoload = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoload)) {
    die("Vendor autoload not found. Run composer install.");
}
require $autoload;

// 2. Bootstrapping
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Paksa folder storage ke /tmp (Wajib di Vercel)
$app->useStoragePath('/tmp');

// 4. Jalankan Request
$app->handleRequest(Request::capture());
