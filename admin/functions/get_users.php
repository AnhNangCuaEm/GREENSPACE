<?php
session_start();
require_once __DIR__ . '/../../class/UserData.php';
require_once __DIR__ . '/../../functions/verify.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}
$users = UserData::getAllUsers(); // You'll need to add this method to UserData class
header('Content-Type: application/json');
echo json_encode($users);
