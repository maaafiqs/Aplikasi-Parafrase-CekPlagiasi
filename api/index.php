<?php

// Set environment defaults for Vercel Serverless
$appKey = getenv('APP_KEY') ?: ($_ENV['APP_KEY'] ?? 'base64:z8LAlxHo9ufEoZgYKyVry1VLBuPvP2h9fWycX6sKm9U=');
$appDebug = getenv('APP_DEBUG') ?: ($_ENV['APP_DEBUG'] ?? 'true');
$appUrl = getenv('APP_URL') ?: ($_ENV['APP_URL'] ?? 'https://tulcek-app.vercel.app');

putenv('VERCEL=1');
putenv("APP_KEY={$appKey}");
putenv("APP_DEBUG={$appDebug}");
putenv("APP_URL={$appUrl}");
putenv('APP_ENV=production');
putenv('SESSION_DRIVER=array');
putenv('CACHE_STORE=array');
putenv('CACHE_DRIVER=array');
putenv('QUEUE_CONNECTION=sync');
putenv('LOG_CHANNEL=stderr');
putenv('VIEW_COMPILED_PATH=/tmp/views');

$_ENV['VERCEL'] = '1';
$_ENV['APP_KEY'] = $appKey;
$_ENV['APP_DEBUG'] = $appDebug;
$_ENV['APP_URL'] = $appUrl;
$_ENV['APP_ENV'] = 'production';
$_ENV['SESSION_DRIVER'] = 'array';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['CACHE_DRIVER'] = 'array';
$_ENV['QUEUE_CONNECTION'] = 'sync';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';

$_SERVER['VERCEL'] = '1';
$_SERVER['APP_KEY'] = $appKey;
$_SERVER['APP_DEBUG'] = $appDebug;
$_SERVER['SESSION_DRIVER'] = 'array';
$_SERVER['LOG_CHANNEL'] = 'stderr';

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
        @mkdir($path, 0755, true);
    }
}
@touch('/tmp/storage/logs/laravel.log');

// Forward request to Laravel public index.php
require __DIR__ . '/../public/index.php';
