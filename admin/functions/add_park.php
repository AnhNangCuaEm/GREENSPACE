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

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

try {
    $result = ParkData::addPark(
        $data['name'],
        $data['location'],
        $data['area'],
        $data['price'],
        $data['nearest'],
        $data['special'],
        $data['description'],
        $data['thumbnail'],
        $data['map'],
        $data['parkfeature'],
        $data['name_yomi'],
        $data['location_yomi'],
        $data['name_romaji'],
        $data['location_romaji']
    );

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
