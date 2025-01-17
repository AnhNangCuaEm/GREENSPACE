<?php
require_once '../class/ParkImageData.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['image_url'])) {
    echo json_encode(['success' => false, 'message' => 'Image URL is required']);
    exit;
}

// Tìm image_id dựa trên image_url và xóa
$success = ParkImageData::deleteParkImageByUrl($data['image_url']);

echo json_encode(['success' => $success]);