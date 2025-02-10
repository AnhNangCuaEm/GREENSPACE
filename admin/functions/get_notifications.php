<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/Database.php';

checkAdmin();

header('Content-Type: application/json');

try {
   if (!isset($_SESSION['email'])) {
      throw new Exception('Unauthorized access');
   }

   $pdo = Database::getConnection();

   // Get all notifications with target information
   $sql = "SELECT n.*,
            CASE 
                WHEN n.target_type = 'all' THEN '全員'
                ELSE COALESCE(GROUP_CONCAT(nt.target_email SEPARATOR ', '), '指定')
            END as target_display
            FROM notifications n
            LEFT JOIN notification_targets nt ON n.id = nt.notification_id
            GROUP BY n.id, n.title, n.content, n.created_by, n.target_type, n.created_at, n.is_active
            ORDER BY n.created_at DESC";

   $stmt = $pdo->prepare($sql);
   $stmt->execute();
   $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

   if (empty($notifications)) {
      echo json_encode([
         'status' => 'empty',
         'message' => 'No notifications found'
      ]);
      exit;
   }

   echo json_encode([
      'status' => 'success',
      'data' => $notifications
   ]);
} catch (Exception $e) {
   http_response_code(500);
   echo json_encode([
      'status' => 'error',
      'message' => $e->getMessage()
   ]);
}
