<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow JSON content type
header('Content-Type: application/json');

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['email']) || !isset($data['status']) || 
    !in_array($data['status'], ['active', 'deactive', 'banned'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

try {
    // Database connection (adjust credentials as needed)
    $pdo = new PDO(
        "mysql:host=localhost;dbname=your_database_name",
        "your_username",
        "your_password",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Update user status
    $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE email = ?");
    $success = $stmt->execute([$data['status'], $data['email']]);

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Status updated successfully' : 'Failed to update status'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}