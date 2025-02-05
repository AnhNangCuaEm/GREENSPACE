<?php
session_start();
require_once __DIR__ . '/../../class/ParkImageData.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['park_id']) || !isset($data['image_url'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit;
}

$success = ParkImageData::addParkImage($data['park_id'], $data['image_url']);

echo json_encode(['success' => $success]);
