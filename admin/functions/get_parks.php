<?php
require_once __DIR__ . '/../../class/ParkData.php';

header('Content-Type: application/json');

try {
    $parks = ParkData::getAllParks();
    echo json_encode($parks);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
