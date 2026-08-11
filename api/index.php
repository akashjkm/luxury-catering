<?php
$projectRoot = dirname(__DIR__);
chdir($projectRoot);

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH) ?: '/';
$path = '/' . ltrim(rawurldecode($path), '/');

if ($path === '/' || $path === '') {
    $requestedFile = '/index.php';
} else {
    $requestedFile = $path;

    if (substr($requestedFile, -1) === '/') {
        $requestedFile .= 'index.php';
    } elseif (pathinfo($requestedFile, PATHINFO_EXTENSION) === '') {
        $candidate = $requestedFile . '.php';
        if (is_file($projectRoot . $candidate)) {
            $requestedFile = $candidate;
        }
    }
}

$absolutePath = $projectRoot . $requestedFile;

if (!is_file($absolutePath) || !is_readable($absolutePath)) {
    http_response_code(404);
    echo '404 Not Found';
    exit;
}

require $absolutePath;
