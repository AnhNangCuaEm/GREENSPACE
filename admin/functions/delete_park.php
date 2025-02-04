<?php
session_start();
require_once __DIR__ . '/../../class/ParkData.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

try {
    // Kiểm tra xem công viên có tồn tại không
    $park = ParkData::getPark($data['id']);
    if (!$park) {
        echo json_encode(['success' => false, 'message' => 'Park not found']);
        exit;
    }

    $result = ParkData::deletePark($data['id']);
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete park']);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage(),
        'error' => true
    ]);
}
