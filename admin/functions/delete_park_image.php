<?php
session_start();
require_once __DIR__ . '/../../class/ParkImageData.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['image_id'])) {
    echo json_encode(['success' => false, 'message' => 'Image ID is required']);
    exit;
}

$success = ParkImageData::deleteParkImage($data['image_id']);

echo json_encode(['success' => $success]);
