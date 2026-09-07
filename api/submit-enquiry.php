<?php
/**
 * Submit Enquiry API Handler
 * Gourmet Affair - Luxury Catering
 */
header('Content-Type: application/json; charset=utf-8');

require_once dirname(__DIR__) . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// Support both JSON body and standard Form POST
$rawInput = file_get_contents('php://input');
$jsonData = json_decode($rawInput, true);
$data = is_array($jsonData) ? $jsonData : $_POST;

$name      = trim($data['name'] ?? '');
$email     = trim($data['email'] ?? '');
$phone     = trim($data['phone'] ?? '');
$eventType = trim($data['event_type'] ?? '');
$eventDate = trim($data['event_date'] ?? '');
$venue     = trim($data['venue'] ?? '');
$message   = trim($data['message'] ?? '');
$source    = trim($data['source'] ?? 'modal_enquiry');

// Basic Validation
if (empty($name) || empty($email) || empty($phone)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields (Name, Email, Phone).']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit;
}

try {
    if (isDbConnected()) {
        $sql = "INSERT INTO inquiries (name, email, phone, event_type, event_date, venue, message, source, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'new')";
        $success = dbExecute($sql, [$name, $email, $phone, $eventType, $eventDate, $venue, $message, $source]);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => "Thank you, {$name}! Your enquiry has been received. Our team will contact you within 24 hours."
            ]);
            exit;
        }
    }

    // Fallback if DB connection fails
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Unable to submit enquiry at this time. Please try again later.']);
} catch (Exception $e) {
    error_log("submit-enquiry error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'An error occurred while saving your enquiry.']);
}
