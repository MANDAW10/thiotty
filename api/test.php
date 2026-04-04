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
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$database = getenv('DB_DATABASE');
$username = getenv('DB_USERNAME');
$sslmode = getenv('DB_SSLMODE') ?: 'require';

echo "Testing connection to: $host:$port (DB: $database, User: $username, SSL: $sslmode)\n";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;sslmode=$sslmode";
    $pdo = new PDO($dsn, $username, getenv('DB_PASSWORD'), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "Database connection: SUCCESS\n";
} catch (Exception $e) {
    echo "Database connection: FAILED - " . $e->getMessage() . "\n";
}
