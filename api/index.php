<?php

use Illuminate\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

// Coba memuat aplikasi
$app = require_once __DIR__ . '/../bootstrap/app.php';

// JIka $app gagal dimuat, kita akan tahu di sini
if (!$app) {
    die("Gagal memuat bootstrap/app.php");
}

$app->useStoragePath('/tmp');

// Tambahkan echo untuk test
// echo "Laravel Booted!"; 

$app->handleRequest(Request::capture());
