<?php
require_once __DIR__ . '/../../class/Database.php';

try {
   $pdo = Database::getConnection();
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // Lấy thông tin cơ bản từ bảng notifications
   $sql = "SELECT n.*, 
            GROUP_CONCAT(nt.target_email) as target_emails,
            COUNT(DISTINCT nr.recipient_email) as read_count
            FROM notifications n
            LEFT JOIN notification_targets nt ON n.id = nt.notification_id
            LEFT JOIN notification_recipients nr ON n.id = nr.notification_id AND nr.is_read = 1
            GROUP BY n.id
            ORDER BY n.created_at DESC";

   $stmt = $pdo->prepare($sql);
   $stmt->execute();
   $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

   if (empty($notifications)) {
      echo json_encode([
         'status' => 'empty',
         'message' => 'No notifications found',
         'data' => []
      ]);
   } else {
      // Format dữ liệu trước khi trả về
      foreach ($notifications as &$notification) {
         // Xử lý target_type
         if ($notification['target_type'] === 'all') {
            $notification['target_display'] = '全員';
         } else {
            $emails = explode(',', $notification['target_emails']);
            $notification['target_display'] = count($emails) . '人のユーザー';
         }
      }

      echo json_encode([
         'status' => 'success',
         'count' => count($notifications),
         'data' => $notifications
      ]);
   }
} catch (PDOException $e) {
   echo json_encode([
      'status' => 'error',
      'message' => $e->getMessage(),
      'code' => $e->getCode()
   ]);
}
