<?php

use Illuminate\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Paksa Laravel mendaftarkan ViewServiceProvider jika belum
if (!$app->bound('view')) {
    $app->register(Illuminate\View\ViewServiceProvider::class);
    $app->register(Illuminate\Events\EventServiceProvider::class);
}

$app->useStoragePath('/tmp');

try {
    $app->handleRequest(Request::capture());
} catch (\Exception $e) {
    echo "<h1>Fatal Error Detected:</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<p>File: " . $e->getFile() . "</p>";
}
