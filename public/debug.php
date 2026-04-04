<?php
header('Content-Type: text/plain');
echo "PHP Version: " . phpversion() . "\n";
echo "Current Dir: " . __DIR__ . "\n";
echo "Base Path: " . realpath(__DIR__ . '/..') . "\n";

echo "\n--- DIR STRUCTURE ---\n";
function listDir($path) {
    if (!is_dir($path)) return;
    $files = scandir($path);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $full = $path . '/' . $file;
        echo (is_dir($full) ? "[DIR] " : "[FILE] ") . $full . "\n";
        if (is_dir($full) && in_array($file, ['app', 'bootstrap', 'public', 'Http', 'Controllers'])) {
            listDir($full);
        }
    }
}
listDir(realpath(__DIR__ . '/..'));

echo "\n--- EXTENSIONS ---\n";
print_r(get_loaded_extensions());

echo "\n--- COMPOSER CHECK ---\n";
$autoload = __DIR__ . '/../vendor/autoload.php';
echo "Autoload exists: " . (file_exists($autoload) ? "YES" : "NO") . "\n";
