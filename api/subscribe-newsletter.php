<?php
/**
 * Newsletter Subscription API Handler
 * Gourmet Affair - Luxury Catering
 */
header('Content-Type: application/json; charset=utf-8');

require_once dirname(__DIR__) . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$rawInput = file_get_contents('php://input');
$jsonData = json_decode($rawInput, true);
$data = is_array($jsonData) ? $jsonData : $_POST;

$email = trim($data['email'] ?? '');

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit;
}

try {
    if (isDbConnected()) {
        $sql = "INSERT INTO newsletter_subscribers (email, status) 
                VALUES (?, 'subscribed') 
                ON DUPLICATE KEY UPDATE status = 'subscribed'";
        $success = dbExecute($sql, [$email]);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Thank you for subscribing to our Culinary Journal!'
            ]);
            exit;
        }
    }

    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection unavailable. Please try again.']);
} catch (Exception $e) {
    error_log("subscribe-newsletter error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Unable to complete subscription at this time.']);
}
