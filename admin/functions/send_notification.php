<?php
session_start();
require_once __DIR__ . '/../../class/Database.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id'])) {
        throw new Exception('Notification ID is required');
    }

    $pdo = Database::getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start transaction
    $pdo->beginTransaction();

    try {
        // Get notification details
        $stmt = $pdo->prepare("SELECT target_type FROM notifications WHERE id = ?");
        $stmt->execute([$data['id']]);
        $notification = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$notification) {
            throw new Exception('Notification not found');
        }

        // Add to notification_recipients based on target_type
        if ($notification['target_type'] === 'all') {
            $sql = "INSERT INTO notification_recipients (notification_id, recipient_email)
                    SELECT ?, email FROM user WHERE status = 'active'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data['id']]);
        } else {
            $sql = "INSERT INTO notification_recipients (notification_id, recipient_email)
                    SELECT ?, target_email FROM notification_targets WHERE notification_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data['id'], $data['id']]);
        }

        // Update is_active status
        $sql = "UPDATE notifications SET is_active = 1 WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$data['id']]);

        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Notification sent successfully'
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
