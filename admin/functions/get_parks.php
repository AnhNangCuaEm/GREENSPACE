<?php
session_start();
require_once __DIR__ . '/../../class/ParkData.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}
header('Content-Type: application/json');

try {
    $random = isset($_GET['random']) ? filter_var($_GET['random'], FILTER_VALIDATE_BOOLEAN) : false;
    $parks = ParkData::getAllParks($random);
    echo json_encode($parks);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
