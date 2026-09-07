<?php
/**
 * Core PHP Database Connection & Helper Functions
 * Gourmet Affair - Luxury Catering
 */

// Database configuration constants (can be overridden via environment or config)
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
if (!defined('DB_PORT')) define('DB_PORT', getenv('DB_PORT') ?: '3306');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'luxury_catering');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'root');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8mb4');

class Database {
    private static ?PDO $instance = null;
    private static bool $connectionFailed = false;

    /**
     * Get singleton PDO connection instance
     */
    public static function getConnection(): ?PDO {
        if (self::$instance === null && !self::$connectionFailed) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::ATTR_PERSISTENT         => false,
                ];
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                self::$connectionFailed = true;
                error_log("Database connection error: " . $e->getMessage());
                return null;
            }
        }
        return self::$instance;
    }

    /**
     * Check if DB is connected
     */
    public static function isConnected(): bool {
        return self::getConnection() !== null;
    }

    /**
     * Reset connection (useful during setup/testing)
     */
    public static function reset(): void {
        self::$instance = null;
        self::$connectionFailed = false;
    }
}

/**
 * Helper: Get active PDO instance
 */
function getDB(): ?PDO {
    return Database::getConnection();
}

/**
 * Helper: Check database connectivity
 */
function isDbConnected(): bool {
    return Database::isConnected();
}

/**
 * Helper: Execute a parameterized query and return PDOStatement
 */
function dbQuery(string $sql, array $params = []): ?PDOStatement {
    $db = getDB();
    if (!$db) return null;
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("dbQuery error: " . $e->getMessage() . " in query: " . $sql);
        throw $e;
    }
}

/**
 * Helper: Fetch all rows matching a query
 */
function dbFetchAll(string $sql, array $params = []): array {
    $stmt = dbQuery($sql, $params);
    return $stmt ? $stmt->fetchAll() : [];
}

/**
 * Helper: Fetch a single row
 */
function dbFetchOne(string $sql, array $params = []): ?array {
    $stmt = dbQuery($sql, $params);
    $result = $stmt ? $stmt->fetch() : false;
    return $result ?: null;
}

/**
 * Helper: Execute an INSERT/UPDATE/DELETE query
 */
function dbExecute(string $sql, array $params = []): bool {
    $stmt = dbQuery($sql, $params);
    return $stmt !== null;
}

/**
 * Helper: Get last inserted ID
 */
function dbLastInsertId(): string {
    $db = getDB();
    return $db ? $db->lastInsertId() : '0';
}
