<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/ParkImageData.php';

checkAdmin();

header('Content-Type: application/json');

try {
    if (!isset($_GET['park_id'])) {
        throw new Exception('Park ID is required');
    }

    $parkId = $_GET['park_id'];

    // Validate parkId
    if (!is_numeric($parkId)) {
        throw new Exception('Invalid park ID');
    }

    $images = ParkImageData::getParkImages($parkId);

    if (!is_array($images)) {
        throw new Exception('Invalid data format');
    }

    echo json_encode($images);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
