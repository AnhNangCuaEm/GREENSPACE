<?php
require_once __DIR__ . '/../../class/ParkImageData.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['image_id'])) {
    echo json_encode(['success' => false, 'message' => 'Image ID is required']);
    exit;
}

$success = ParkImageData::deleteParkImage($data['image_id']);

echo json_encode(['success' => $success]);