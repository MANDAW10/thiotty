<?php
header('Content-Type: text/plain');
echo "PHP Version: " . phpversion() . "\n";
echo "Current Dir: " . __DIR__ . "\n";
echo "Base Path: " . (isset($_SERVER['PWD']) ? $_SERVER['PWD'] : realpath(__DIR__ . '/..')) . "\n";

echo "\n--- DIR STRUCTURE (..) ---\n";
$base = realpath(__DIR__ . '/..');
if ($base) {
    $files = scandir($base);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        echo (is_dir($base . '/' . $file) ? "[DIR] " : "[FILE] ") . $file . "\n";
    }
} else {
    echo "Could not find base path.\n";
}

echo "\n--- EXTENSIONS ---\n";
print_r(get_loaded_extensions());

echo "\n--- COMPOSER CHECK ---\n";
$autoload = __DIR__ . '/../vendor/autoload.php';
echo "Autoload.php exists: " . (file_exists($autoload) ? "YES" : "NO") . "\n";
if (file_exists($autoload)) {
    echo "Autoload path: " . realpath($autoload) . "\n";
}
