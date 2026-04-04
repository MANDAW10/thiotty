<?php
header('Content-Type: text/plain');
echo "PHP Version: " . phpversion() . "\n";

echo "\n--- BOOTSTRAP CACHE CHECK ---\n";
$cachePath = realpath(__DIR__ . '/../bootstrap/cache');
if ($cachePath) {
    $files = scandir($cachePath);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        echo "[FILE] $file\n";
        // If it's a php file, show the first few lines to check for absolute paths
        if (str_ends_with($file, '.php')) {
            $content = file_get_contents($cachePath . '/' . $file);
            if (strpos($content, 'C:\\') !== false || strpos($content, 'Users\\') !== false) {
                echo "   !!! WARNING: Local Windows paths detected in cache file !!!\n";
            }
        }
    }
}

echo "\n--- DIR CASE CHECK ---\n";
function checkCase($path, $level = 0) {
    if ($level > 3) return;
    $files = scandir($path);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        if (in_array(strtolower($file), ['app', 'http', 'controllers', 'auth', 'models', 'providers'])) {
            echo str_repeat("  ", $level) . "$file\n";
            $full = $path . '/' . $file;
            if (is_dir($full)) checkCase($full, $level + 1);
        }
    }
}
checkCase(realpath(__DIR__ . '/..'));

echo "\n--- DATABASE TEST ---\n";
try {
    $dsn = "pgsql:host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT') . ";dbname=" . getenv('DB_DATABASE');
    $pdo = new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    echo "Database connection: SUCCESS\n";
} catch (Exception $e) {
    echo "Database connection: FAILED - " . $e->getMessage() . "\n";
}
