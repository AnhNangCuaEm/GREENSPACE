<?php
require_once __DIR__ . '/../../class/Database.php';

try {
   $data = json_decode(file_get_contents('php://input'), true);

   if (!isset($data['id'])) {
      throw new Exception('Notification ID is required');
   }

   $pdo = Database::getConnection();
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // Bắt đầu transaction
   $pdo->beginTransaction();

   // Xóa từ bảng notification_recipients
   $sql = "DELETE FROM notification_recipients WHERE notification_id = ?";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$data['id']]);

   // Xóa từ bảng notification_targets
   $sql = "DELETE FROM notification_targets WHERE notification_id = ?";
   $stmt = $pdo->prepare($sql);
   $stmt->execute([$data['id']]);

   // Xóa từ bảng notifications
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
