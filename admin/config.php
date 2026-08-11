<?php
session_start();

// Admin credentials (change these in production)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123'); // Change this!

// Base paths
define('ADMIN_PATH', dirname(__FILE__) . '/');
define('DATA_PATH', ADMIN_PATH . 'data/');
define('UPLOAD_PATH', ADMIN_PATH . 'uploads/');
define('SITE_PATH', dirname(ADMIN_PATH) . '/');

// Helper: Check if logged in
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Helper: Require login
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Helper: Read JSON data
function readData($file) {
    $path = DATA_PATH . $file . '.json';
    if (file_exists($path)) {
        $json = file_get_contents($path);
        return json_decode($json, true);
    }
    return [];
}

// Helper: Write JSON data
function writeData($file, $data) {
    $path = DATA_PATH . $file . '.json';
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Helper: Upload image
function uploadImage($file, $prefix = '') {
    if ($file['error'] !== UPLOAD_ERR_OK) return false;

    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed)) return false;

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $prefix . '_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $dest = UPLOAD_PATH . $filename;

    if (move_uploaded_file($file['tmp_name'], $dest)) {
        return 'admin/uploads/' . $filename;
    }
    return false;
}

// Helper: Delete image
function deleteImage($path) {
    $full = SITE_PATH . $path;
    if (file_exists($full) && strpos($path, 'admin/uploads/') === 0) {
        unlink($full);
        return true;
    }
    return false;
}

// Helper: Flash message
function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
?>
