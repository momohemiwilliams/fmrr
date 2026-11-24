<?php

$status = $_POST["newStatus"] ?? $_GET["status"] ?? '';


// Dynamically determine the application URL from .env or current request
$appUrl = '';
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if (strpos($trimmed, 'APP_URL=') === 0) {
            $appUrl = trim(substr($trimmed, 8), " \t\n\r\0\x0B'\"");
            break;
        }
    }
}

if (empty($appUrl)) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
    $protocol = $isHttps ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $dir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
    $appUrl = $protocol . $host . ($dir ? '/' . ltrim($dir, '/') : '');
}

$redirectUrl = rtrim($appUrl, '/') . '/payment/success?status=' . urlencode((string)$status);
header("Location: " . $redirectUrl);
exit;  
