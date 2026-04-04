<?php

// Enable error reporting to THE SCREEN (only for debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require __DIR__ . '/../vendor/autoload.php';
    /** @var \Illuminate\Foundation\Application $app */
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // HARD FORCED REGISTRATION: Ignore auto-discovery, force load the core
    $coreProviders = [
        \Illuminate\Filesystem\FilesystemServiceProvider::class,
        \Illuminate\View\ViewServiceProvider::class,
        \Illuminate\Session\SessionServiceProvider::class,
        \Illuminate\Cache\CacheServiceProvider::class,
        \Illuminate\Database\DatabaseServiceProvider::class,
        \Illuminate\Encryption\EncryptionServiceProvider::class,
        \Illuminate\Translation\TranslationServiceProvider::class,
    ];

    foreach ($coreProviders as $provider) {
        if (!$app->getProvider($provider)) {
            $app->register($provider);
        }
    }

    $storagePath = '/tmp/storage';
    foreach (['/framework/views', '/framework/sessions', '/framework/cache'] as $sub) {
        if (!is_dir($storagePath.$sub)) mkdir($storagePath.$sub, 0755, true);
    }
    $app->useStoragePath($storagePath);

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    // We catch the request manually to avoid the Kernel's built-in error handler if possible
    $request = Illuminate\Http\Request::capture();
    
    // If the kernel handles it and fails, it returns a response. 
    // We want to see if we can trigger the error ourselves.
    $response = $kernel->handle($request);
    
    // If we have an error status, let's try to extract the exception from the response if it's there
    if ($response->isServerError() || $response->isClientError()) {
        echo "--- HTTP ERROR " . $response->getStatusCode() . " DETECTED ---\n";
        if (isset($response->exception)) {
            echo "Exception: " . $response->exception->getMessage() . "\n";
            echo "Trace: " . $response->exception->getTraceAsString() . "\n";
        }
    }

    $response->send();
    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    echo "--- CRITICAL BOOT ERROR ---\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
    echo "Full Trace: \n" . $e->getTraceAsString() . "\n";
}
