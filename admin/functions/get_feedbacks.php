<?php
session_start();
require_once __DIR__ . '/../../class/Database.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

try {
    $pdo = Database::getConnection();

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM feedback ORDER BY created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($feedbacks)) {
        echo json_encode([
            'status' => 'empty',
            'message' => 'No feedbacks found',
            'data' => []
        ]);
    } else {
        echo json_encode([
            'status' => 'success',
            'count' => count($feedbacks),
            'data' => $feedbacks
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
}
