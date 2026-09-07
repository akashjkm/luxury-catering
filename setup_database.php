<?php
/**
 * Database Setup & Migration Script
 * Gourmet Affair - Luxury Catering
 *
 * Can be run from CLI: php setup_database.php
 * Or via browser: http://localhost/luxury-catering/setup_database.php
 */

$isCli = (php_sapi_name() === 'cli');

function outputMsg($msg, $type = 'info') {
    global $isCli;
    if ($isCli) {
        $prefix = match($type) {
            'success' => '[SUCCESS] ',
            'error'   => '[ERROR] ',
            'warning' => '[WARNING] ',
            default   => '[INFO] '
        };
        echo $prefix . $msg . "\n";
    } else {
        $color = match($type) {
            'success' => '#28a745',
            'error'   => '#dc3545',
            'warning' => '#ffc107',
            default   => '#17a2b8'
        };
        echo "<div style='padding: 10px 15px; margin-bottom: 8px; border-radius: 4px; background: #1c1c1c; color: #fff; border-left: 4px solid {$color}; font-family: monospace;'>";
        echo "<strong>" . strtoupper($type) . ":</strong> " . htmlspecialchars($msg);
        echo "</div>";
    }
}

if (!$isCli) {
    echo "<!DOCTYPE html><html><head><title>Database Setup | Gourmet Affair</title>";
    echo "<style>body { background: #0a0a0a; color: #eee; font-family: sans-serif; padding: 40px; max-width: 800px; margin: 0 auto; }</style>";
    echo "</head><body><h2 style='color: #C9A962;'>Gourmet Affair — Database Setup & Migration</h2>";
}

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_NAME') ?: 'luxury_catering';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';

try {
    outputMsg("Connecting to MySQL server at {$dbHost}:{$dbPort}...", 'info');
    $pdo = new PDO("mysql:host={$dbHost};port={$dbPort};charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    outputMsg("Connected to MySQL server successfully.", 'success');

    // 1. Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $pdo->exec("USE `{$dbName}`;");
    outputMsg("Database `{$dbName}` selected.", 'success');

    // 2. Create tables
    outputMsg("Creating database tables...", 'info');

    // Admins table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `admins` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `email` VARCHAR(100) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Settings table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `settings` (
            `setting_key` VARCHAR(100) PRIMARY KEY,
            `setting_value` TEXT,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Site Content table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `site_content` (
            `section_key` VARCHAR(100) PRIMARY KEY,
            `content_json` LONGTEXT NOT NULL,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Menu Categories
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `menu_categories` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `slug` VARCHAR(50) NOT NULL UNIQUE,
            `name` VARCHAR(100) NOT NULL,
            `display_order` INT DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Menu Items
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `menu_items` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `category_slug` VARCHAR(50) NOT NULL,
            `name` VARCHAR(150) NOT NULL,
            `description` TEXT,
            `price` VARCHAR(50),
            `image` VARCHAR(255) NULL,
            `display_order` INT DEFAULT 0,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX (`category_slug`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Testimonials
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `testimonials` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(100) NOT NULL,
            `company` VARCHAR(150),
            `quote` TEXT NOT NULL,
            `photo` VARCHAR(255),
            `display_order` INT DEFAULT 0,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Gallery
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `gallery` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(150) NOT NULL,
            `location` VARCHAR(150),
            `image` VARCHAR(255) NOT NULL,
            `category` VARCHAR(50) DEFAULT 'general',
            `display_order` INT DEFAULT 0,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Inquiries
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `inquiries` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(100) NOT NULL,
            `email` VARCHAR(100) NOT NULL,
            `phone` VARCHAR(50) NOT NULL,
            `event_type` VARCHAR(100) NULL,
            `event_date` VARCHAR(100) NULL,
            `venue` VARCHAR(255) NULL,
            `message` TEXT NULL,
            `source` VARCHAR(50) DEFAULT 'contact_page',
            `status` ENUM('new', 'contacted', 'archived') DEFAULT 'new',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Newsletter Subscribers
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `email` VARCHAR(150) NOT NULL UNIQUE,
            `status` ENUM('subscribed', 'unsubscribed') DEFAULT 'subscribed',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    outputMsg("All database tables created or verified.", 'success');

    // 3. Seed default Admin User if not present
    $stmt = $pdo->prepare("SELECT id FROM `admins` WHERE `username` = ?");
    $stmt->execute(['admin']);
    if (!$stmt->fetch()) {
        $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $insertAdmin = $pdo->prepare("INSERT INTO `admins` (`username`, `password`, `email`) VALUES (?, ?, ?)");
        $insertAdmin->execute(['admin', $defaultPassword, 'admin@gourmetaffair.com']);
        outputMsg("Default admin account created: username 'admin', password 'admin123'.", 'success');
    } else {
        outputMsg("Admin account already exists.", 'info');
    }

    // 4. Migrate existing JSON data
    $dataPath = __DIR__ . '/admin/data/';

    // Settings migration
    if (file_exists($dataPath . 'settings.json')) {
        $settings = json_decode(file_get_contents($dataPath . 'settings.json'), true);
        if (is_array($settings)) {
            $stmt = $pdo->prepare("INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`)");
            foreach ($settings as $k => $v) {
                $stmt->execute([$k, is_array($v) ? json_encode($v) : (string)$v]);
            }
            outputMsg("Migrated " . count($settings) . " settings entries from settings.json.", 'success');
        }
    }

    // Content migration
    if (file_exists($dataPath . 'content.json')) {
        $content = json_decode(file_get_contents($dataPath . 'content.json'), true);
        if (is_array($content)) {
            $stmt = $pdo->prepare("INSERT INTO `site_content` (`section_key`, `content_json`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `content_json` = VALUES(`content_json`)");
            foreach ($content as $section => $secData) {
                $stmt->execute([$section, json_encode($secData, JSON_UNESCAPED_UNICODE)]);
            }
            outputMsg("Migrated " . count($content) . " content sections from content.json.", 'success');
        }
    }

    // Menu Categories & Items migration
    $defaultCategories = [
        'contemporary_european' => ['name' => 'Contemporary European', 'order' => 1],
        'pan_asian_fusion'     => ['name' => 'Pan-Asian Fusion', 'order' => 2],
        'farm_to_table'         => ['name' => 'Farm-to-Table', 'order' => 3],
    ];

    $catStmt = $pdo->prepare("INSERT INTO `menu_categories` (`slug`, `name`, `display_order`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `display_order` = VALUES(`display_order`)");
    foreach ($defaultCategories as $slug => $cat) {
        $catStmt->execute([$slug, $cat['name'], $cat['order']]);
    }

    if (file_exists($dataPath . 'menu.json')) {
        $menu = json_decode(file_get_contents($dataPath . 'menu.json'), true);
        if (is_array($menu)) {
            // Check if menu_items already has rows
            $itemCount = $pdo->query("SELECT COUNT(*) FROM `menu_items`")->fetchColumn();
            if ((int)$itemCount === 0) {
                $itemStmt = $pdo->prepare("INSERT INTO `menu_items` (`category_slug`, `name`, `description`, `price`, `display_order`) VALUES (?, ?, ?, ?, ?)");
                $migratedCount = 0;
                foreach ($menu as $catSlug => $items) {
                    if (is_array($items)) {
                        $order = 1;
                        foreach ($items as $item) {
                            $itemStmt->execute([
                                $catSlug,
                                $item['name'] ?? '',
                                $item['desc'] ?? '',
                                $item['price'] ?? '',
                                $order++
                            ]);
                            $migratedCount++;
                        }
                    }
                }
                outputMsg("Migrated {$migratedCount} menu items from menu.json.", 'success');
            } else {
                outputMsg("Menu items already present in database ({$itemCount} items).", 'info');
            }
        }
    }

    // Testimonials migration
    if (file_exists($dataPath . 'testimonials.json')) {
        $testimonials = json_decode(file_get_contents($dataPath . 'testimonials.json'), true);
        if (is_array($testimonials)) {
            $testCount = $pdo->query("SELECT COUNT(*) FROM `testimonials`")->fetchColumn();
            if ((int)$testCount === 0) {
                $testStmt = $pdo->prepare("INSERT INTO `testimonials` (`name`, `company`, `quote`, `photo`, `display_order`) VALUES (?, ?, ?, ?, ?)");
                $tOrder = 1;
                foreach ($testimonials as $t) {
                    $testStmt->execute([
                        $t['name'] ?? '',
                        $t['company'] ?? '',
                        $t['quote'] ?? '',
                        $t['photo'] ?? '',
                        $tOrder++
                    ]);
                }
                outputMsg("Migrated " . count($testimonials) . " testimonials from testimonials.json.", 'success');
            } else {
                outputMsg("Testimonials already present in database ({$testCount} records).", 'info');
            }
        }
    }

    // Gallery migration
    if (file_exists($dataPath . 'gallery.json')) {
        $gallery = json_decode(file_get_contents($dataPath . 'gallery.json'), true);
        if (is_array($gallery)) {
            $galCount = $pdo->query("SELECT COUNT(*) FROM `gallery`")->fetchColumn();
            if ((int)$galCount === 0) {
                $galStmt = $pdo->prepare("INSERT INTO `gallery` (`title`, `location`, `image`, `category`, `display_order`) VALUES (?, ?, ?, ?, ?)");
                $gOrder = 1;
                foreach ($gallery as $g) {
                    $galStmt->execute([
                        $g['title'] ?? '',
                        $g['location'] ?? '',
                        $g['image'] ?? '',
                        $g['category'] ?? 'general',
                        $gOrder++
                    ]);
                }
                outputMsg("Migrated " . count($gallery) . " gallery items from gallery.json.", 'success');
            } else {
                outputMsg("Gallery already present in database ({$galCount} records).", 'info');
            }
        }
    }

    outputMsg("Database setup and migration completed successfully!", 'success');
    if (!$isCli) {
        echo "<p style='margin-top: 25px;'><a href='admin/login.php' style='display: inline-block; padding: 10px 20px; background: #C9A962; color: #000; text-decoration: none; font-weight: bold;'>Go to Admin Panel &rarr;</a></p>";
    }

} catch (PDOException $e) {
    outputMsg("Database Error: " . $e->getMessage(), 'error');
}

if (!$isCli) {
    echo "</body></html>";
}
