<?php
session_start();
require_once __DIR__ . '/../class/UserData.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['avatar']) && isset($_SESSION['email'])) {
    $newAvatar = $data['avatar'];
    $email = $_SESSION['email'];

    try {
        UserData::updateAvatar($email, $newAvatar);
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}