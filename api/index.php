<?php

// Enable error reporting to THE SCREEN (only for debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $storagePath = '/tmp/storage';
    foreach (['/framework/views', '/framework/sessions', '/framework/cache'] as $sub) {
        if (!is_dir($storagePath.$sub)) mkdir($storagePath.$sub, 0755, true);
    }
    $app->useStoragePath($storagePath);

    // Force a minimal 'view' binding to prevent the error renderer from crashing
    $app->singleton('view', function() {
        return new class { public function replaceNamespace() {} public function exists() { return false; } public function make() { return $this; } public function render() { return 'Error page failed to load (View service missing)'; } };
    });

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle($request = Illuminate\Http\Request::capture());
    $response->send();
    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    echo "--- ROOT EXCEPTION DETECTED ---\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
    if ($e->getPrevious()) {
        echo "Previous Exception: " . $e->getPrevious()->getMessage() . "\n";
    }
    echo "Full Trace: \n" . $e->getTraceAsString() . "\n";
}
