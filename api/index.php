<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

// Bootstrapping aplikasi
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Paksa folder storage ke /tmp
$app->useStoragePath('/tmp');

// Jalankan aplikasi
$app->handleRequest(Request::capture());
