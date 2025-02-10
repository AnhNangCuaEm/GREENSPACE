<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/ParkData.php';

checkAdmin();

header('Content-Type: application/json');

try {
    $random = isset($_GET['random']) ? filter_var($_GET['random'], FILTER_VALIDATE_BOOLEAN) : false;
    $parks = ParkData::getAllParks($random);
    echo json_encode($parks);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
