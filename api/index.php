<?php

use Illuminate\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

// Memaksa Laravel menggunakan folder /tmp untuk cache/views karena Vercel Read-Only
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->useStoragePath('/tmp');

$app->handleRequest(Request::capture());
