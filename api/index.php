<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Load Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 2. Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. FIX VERCEL SERVERLESS: Alihkan semua proses write ke /tmp
$app->useStoragePath('/tmp/storage');

// 4. FIX VIEW ENGINE ERROR: Buat paksa kerangka folder agar view bisa di-render
$dirs = [
    '/tmp/storage/app',
    '/tmp/storage/logs',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 5. Force JSON Header untuk mengatasi error rendering exception
$request = Request::capture();
$request->headers->set('Accept', 'application/json');

// 6. Jalankan Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request)->send();
$kernel->terminate($request, $response);
