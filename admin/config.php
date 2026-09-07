<?php
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

// Admin credentials (fallback when DB is unavailable)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123');

// Base paths
define('ADMIN_PATH', dirname(__FILE__) . '/');
define('DATA_PATH', ADMIN_PATH . 'data/');
define('UPLOAD_PATH', ADMIN_PATH . 'uploads/');
define('SITE_PATH', dirname(ADMIN_PATH) . '/');

// Include Core Database connection
require_once SITE_PATH . 'includes/db.php';

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

// Helper: Read JSON fallback directly
function readDataFromJson($file) {
    $path = DATA_PATH . $file . '.json';
    if (file_exists($path)) {
        $json = file_get_contents($path);
        return json_decode($json, true) ?: [];
    }
    return [];
}

// Helper: Write JSON backup directly
function writeDataToJson($file, $data) {
    $path = DATA_PATH . $file . '.json';
    if (!is_dir(DATA_PATH)) {
        @mkdir(DATA_PATH, 0755, true);
    }
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Helper: Read data from Database with JSON fallback
function readData($file) {
    if (!isDbConnected()) {
        return readDataFromJson($file);
    }

    try {
        switch ($file) {
            case 'settings':
                $rows = dbFetchAll("SELECT setting_key, setting_value FROM settings");
                if (!empty($rows)) {
                    $result = [];
                    foreach ($rows as $r) {
                        $val = $r['setting_value'];
                        $decoded = json_decode($val, true);
                        $result[$r['setting_key']] = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : $val;
                    }
                    return $result;
                }
                break;

            case 'content':
                $rows = dbFetchAll("SELECT section_key, content_json FROM site_content");
                if (!empty($rows)) {
                    $result = [];
                    foreach ($rows as $r) {
                        $decoded = json_decode($r['content_json'], true);
                        $result[$r['section_key']] = is_array($decoded) ? $decoded : [];
                    }
                    return $result;
                }
                break;

            case 'menu':
                $rows = dbFetchAll("SELECT id, category_slug, name, description AS `desc`, price, image, display_order FROM menu_items ORDER BY display_order ASC, id ASC");
                if (!empty($rows)) {
                    $result = [];
                    foreach ($rows as $r) {
                        $cat = $r['category_slug'];
                        if (!isset($result[$cat])) $result[$cat] = [];
                        $result[$cat][] = [
                            'id'    => (int)$r['id'],
                            'name'  => $r['name'],
                            'desc'  => $r['desc'],
                            'price' => $r['price'],
                            'image' => $r['image']
                        ];
                    }
                    return $result;
                }
                break;

            case 'testimonials':
                $rows = dbFetchAll("SELECT id, name, company, quote, photo, display_order FROM testimonials ORDER BY display_order ASC, id ASC");
                if (!empty($rows)) {
                    return array_map(function($r) {
                        return [
                            'id'      => (int)$r['id'],
                            'name'    => $r['name'],
                            'company' => $r['company'],
                            'quote'   => $r['quote'],
                            'photo'   => $r['photo']
                        ];
                    }, $rows);
                }
                break;

            case 'gallery':
                $rows = dbFetchAll("SELECT id, title, location, image, category, display_order FROM gallery ORDER BY display_order ASC, id ASC");
                if (!empty($rows)) {
                    return array_map(function($r) {
                        return [
                            'id'       => (int)$r['id'],
                            'title'    => $r['title'],
                            'location' => $r['location'],
                            'image'    => $r['image'],
                            'category' => $r['category']
                        ];
                    }, $rows);
                }
                break;
        }
    } catch (Exception $e) {
        error_log("readData error for {$file}: " . $e->getMessage());
    }

    return readDataFromJson($file);
}

// Helper: Write data to Database with JSON backup
function writeData($file, $data) {
    // 1. Always update JSON backup
    writeDataToJson($file, $data);

    // 2. Persist to MySQL DB
    if (!isDbConnected()) {
        return;
    }

    try {
        $pdo = getDB();
        switch ($file) {
            case 'settings':
                if (is_array($data)) {
                    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
                    foreach ($data as $k => $v) {
                        $stmt->execute([$k, is_array($v) ? json_encode($v) : (string)$v]);
                    }
                }
                break;

            case 'content':
                if (is_array($data)) {
                    $stmt = $pdo->prepare("INSERT INTO site_content (section_key, content_json) VALUES (?, ?) ON DUPLICATE KEY UPDATE content_json = VALUES(content_json)");
                    foreach ($data as $section => $secData) {
                        $stmt->execute([$section, json_encode($secData, JSON_UNESCAPED_UNICODE)]);
                    }
                }
                break;

            case 'menu':
                if (is_array($data)) {
                    $pdo->beginTransaction();
                    $pdo->exec("DELETE FROM menu_items");
                    $stmt = $pdo->prepare("INSERT INTO menu_items (category_slug, name, description, price, display_order) VALUES (?, ?, ?, ?, ?)");
                    foreach ($data as $catSlug => $items) {
                        if (is_array($items)) {
                            $order = 1;
                            foreach ($items as $item) {
                                $stmt->execute([
                                    $catSlug,
                                    $item['name'] ?? '',
                                    $item['desc'] ?? '',
                                    $item['price'] ?? '',
                                    $order++
                                ]);
                            }
                        }
                    }
                    $pdo->commit();
                }
                break;

            case 'testimonials':
                if (is_array($data)) {
                    $pdo->beginTransaction();
                    $pdo->exec("DELETE FROM testimonials");
                    $stmt = $pdo->prepare("INSERT INTO testimonials (name, company, quote, photo, display_order) VALUES (?, ?, ?, ?, ?)");
                    $tOrder = 1;
                    foreach ($data as $t) {
                        $stmt->execute([
                            $t['name'] ?? '',
                            $t['company'] ?? '',
                            $t['quote'] ?? '',
                            $t['photo'] ?? '',
                            $tOrder++
                        ]);
                    }
                    $pdo->commit();
                }
                break;

            case 'gallery':
                if (is_array($data)) {
                    $pdo->beginTransaction();
                    $pdo->exec("DELETE FROM gallery");
                    $stmt = $pdo->prepare("INSERT INTO gallery (title, location, image, category, display_order) VALUES (?, ?, ?, ?, ?)");
                    $gOrder = 1;
                    foreach ($data as $g) {
                        $stmt->execute([
                            $g['title'] ?? '',
                            $g['location'] ?? '',
                            $g['image'] ?? '',
                            $g['category'] ?? 'general',
                            $gOrder++
                        ]);
                    }
                    $pdo->commit();
                }
                break;
        }
    } catch (Exception $e) {
        if (isset($pdo) && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("writeData DB error for {$file}: " . $e->getMessage());
    }
}

// Helper: Upload image
function uploadImage($file, $prefix = '') {
    if ($file['error'] !== UPLOAD_ERR_OK) return false;

    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed)) return false;

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $prefix . '_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $dest = UPLOAD_PATH . $filename;

    if (!is_dir(UPLOAD_PATH)) {
        @mkdir(UPLOAD_PATH, 0755, true);
    }

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
