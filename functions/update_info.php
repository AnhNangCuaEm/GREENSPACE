<?php
require_once __DIR__ . '/../class/UserData.php';
session_start();

// Get JSON data from request body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['email'])) {
    http_response_code(401);
    exit('Unauthorized');
}

try {
    $email = $_SESSION['email'];
    
    // Update user info (name, phone, address)
    if (isset($data['name']) && isset($data['phone']) && isset($data['address'])) {
        UserData::updateInfo($email, $data['name'], $data['phone'], $data['address']);
    }
    
    // Update password if requested
    if (isset($data['updatePassword']) && $data['updatePassword'] === true && isset($data['password'])) {
        UserData::updatePassword($email, $data['password']);
    }
    
    http_response_code(200);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}