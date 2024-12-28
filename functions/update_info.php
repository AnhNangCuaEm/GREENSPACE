<?php
session_start();

require_once __DIR__ . '/../class/UserData.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name'], $data['phone'], $data['address']) && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    
    // Log the incoming data for debugging
    error_log('Incoming data: ' . json_encode($data)); // Log incoming data

    try {
        // Update the user information directly using the existing email
        UserData::updateInfo($email, $data['name'], $data['phone'], $data['address']);
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    error_log('Invalid input or session not set');
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}