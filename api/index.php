<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Ensure storage structure exists in /tmp for Vercel
$storagePath = '/tmp/storage';
foreach (['/framework/views', '/framework/sessions', '/framework/cache'] as $sub) {
    if (!is_dir($storagePath.$sub)) {
        mkdir($storagePath.$sub, 0755, true);
    }
}
$app->useStoragePath($storagePath);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
