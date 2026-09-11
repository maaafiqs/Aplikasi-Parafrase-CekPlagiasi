<?php

// Enable error reporting to catch everything
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Shutdown function to catch fatal errors and print them
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
        http_response_code(200);
        header('Content-Type: text/html; charset=utf-8');
        echo "<h1>PHP Fatal Error Caught</h1>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($error['message']) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($error['file']) . ":" . $error['line'] . "</p>";
    }
});

// Set environment defaults for Vercel Serverless
$appKey = getenv('APP_KEY') ?: ($_ENV['APP_KEY'] ?? 'base64:z8LAlxHo9ufEoZgYKyVry1VLBuPvP2h9fWycX6sKm9U=');
$appDebug = getenv('APP_DEBUG') ?: ($_ENV['APP_DEBUG'] ?? 'true');
$appUrl = getenv('APP_URL') ?: ($_ENV['APP_URL'] ?? 'https://tulcek-app.vercel.app');

$serverlessEnv = [
    'VERCEL' => '1',
    'APP_KEY' => $appKey,
    'APP_DEBUG' => 'true',
    'APP_URL' => $appUrl,
    'APP_ENV' => 'production',
    'SESSION_DRIVER' => 'array',
    'SESSION_LIFETIME' => '120',
    'CACHE_STORE' => 'array',
    'CACHE_DRIVER' => 'array',
    'QUEUE_CONNECTION' => 'sync',
    'LOG_CHANNEL' => 'stderr',
    'MAIL_MAILER' => 'log',
    'BROADCAST_CONNECTION' => 'log',
    'FILESYSTEM_DISK' => 'local',
    'VIEW_COMPILED_PATH' => '/tmp/views',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
];

foreach ($serverlessEnv as $k => $v) {
    putenv("{$k}={$v}");
    $_ENV[$k] = $v;
    $_SERVER[$k] = $v;
}

// Ensure writable storage and views directories exist in /tmp for Vercel serverless environment
$storagePaths = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/views',
];

foreach ($storagePaths as $path) {
    if (!is_dir($path)) {
        @mkdir($path, 0777, true);
    }
}
@touch('/tmp/storage/logs/laravel.log');

// Copy cache manifests to /tmp if available so Laravel doesn't try to regenerate in read-only dir
if (!file_exists('/tmp/services.php') && file_exists(__DIR__ . '/../bootstrap/cache/services.php')) {
    @copy(__DIR__ . '/../bootstrap/cache/services.php', '/tmp/services.php');
}
if (!file_exists('/tmp/packages.php') && file_exists(__DIR__ . '/../bootstrap/cache/packages.php')) {
    @copy(__DIR__ . '/../bootstrap/cache/packages.php', '/tmp/packages.php');
}

// Forward request to Laravel public index.php with try/catch
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(200);
    header('Content-Type: text/html; charset=utf-8');
    echo "<h1>Uncaught Exception in index.php</h1>";
    echo "<p><strong>Class:</strong> " . htmlspecialchars(get_class($e)) . "</p>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
