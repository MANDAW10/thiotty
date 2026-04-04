<?php

// Enable error reporting to THE SCREEN (only for debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // HARD FIX: Ensure storage structure exists in /tmp for Vercel
    $storagePath = '/tmp/storage';
    foreach ([
        $storagePath . '/framework/views',
        $storagePath . '/framework/sessions',
        $storagePath . '/framework/cache',
    ] as $path) {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    $app->useStoragePath($storagePath);

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    )->send();

    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    echo "--- FATAL ERROR CAPTURED ---\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
    echo "Trace: \n" . $e->getTraceAsString() . "\n";
}
