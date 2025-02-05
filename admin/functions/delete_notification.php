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
   $data = json_decode(file_get_contents('php://input'), true);

   if (!isset($data['id'])) {
      throw new Exception('Notification ID is required');
   }

   $pdo = Database::getConnection();
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $pdo->beginTransaction();

   $sql = "DELETE FROM notification_recipients WHERE notification_id = ?";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$data['id']]);

   $sql = "DELETE FROM notification_targets WHERE notification_id = ?";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$data['id']]);

   $sql = "DELETE FROM notifications WHERE id = ?";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$data['id']]);

   $pdo->commit();

   echo json_encode([
      'success' => true,
      'message' => 'Notification deleted successfully'
   ]);
} catch (Exception $e) {
   if (isset($pdo)) {
      $pdo->rollBack();
   }
   echo json_encode([
      'success' => false,
      'message' => $e->getMessage()
   ]);
}
