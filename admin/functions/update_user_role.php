<?php
require_once __DIR__ . '/../../class/Database.php';
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow JSON content type
header('Content-Type: application/json');

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['email']) || !isset($data['role']) || 
    !in_array($data['role'], ['user', 'admin'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

try {
    // Use Database class instead of direct PDO connection
    $pdo = Database::getConnection();

    // Update user role
    $stmt = $pdo->prepare("UPDATE user SET role = ? WHERE email = ?");
    $success = $stmt->execute([$data['role'], $data['email']]);

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Role updated successfully' : 'Failed to update role'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}