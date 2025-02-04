<?php
session_start();
require_once __DIR__ . '/../class/Database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['email']) || !isset($_POST['notification_id'])) {
   echo json_encode([
      'success' => false,
      'message' => 'Invalid request'
   ]);
   exit;
}

try {
   $pdo = Database::getConnection();

   $sql = "UPDATE notification_recipients 
            SET is_deleted = 1 
            WHERE notification_id = ? AND recipient_email = ?";

   $stmt = $pdo->prepare($sql);
   $stmt->execute([$_POST['notification_id'], $_SESSION['email']]);

   echo json_encode([
      'success' => true,
      'message' => 'Notification deleted successfully'
   ]);
} catch (Exception $e) {
   echo json_encode([
      'success' => false,
      'message' => 'Error: ' . $e->getMessage()
   ]);
}
