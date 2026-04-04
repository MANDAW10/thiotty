<?php

// Enable error reporting to THE SCREEN (only for debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // Ensure storage structure exists in /tmp for Vercel
    $storagePath = '/tmp/storage';
    foreach (['/framework/views', '/framework/sessions', '/framework/cache'] as $sub) {
        if (!is_dir($storagePath.$sub)) mkdir($storagePath.$sub, 0755, true);
    }
    $app->useStoragePath($storagePath);

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    $response->send();

    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    echo "--- FINAL DIAGNOSTIC --- \n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
    echo "Trace: \n" . $e->getTraceAsString() . "\n";
}
