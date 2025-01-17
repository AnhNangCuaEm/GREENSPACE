<?php
require_once __DIR__ . '/../../class/ParkImageData.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['park_id']) || !isset($data['image_url'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit;
}

$success = ParkImageData::addParkImage($data['park_id'], $data['image_url']);

echo json_encode(['success' => $success]);