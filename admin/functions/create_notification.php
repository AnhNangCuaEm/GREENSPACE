<?php
require_once __DIR__ . '/../../class/Database.php';

try {
   // Lấy dữ liệu từ request
   $data = json_decode(file_get_contents('php://input'), true);

   if (!isset($data['title']) || !isset($data['content']) || !isset($data['target_type'])) {
      throw new Exception('Missing required fields');
   }

   $pdo = Database::getConnection();
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // Bắt đầu transaction
   $pdo->beginTransaction();

   // Thêm notification mới
   $sql = "INSERT INTO notifications (title, content, created_by, target_type, created_at, is_active) 
            VALUES (?, ?, ?, ?, NOW(), 1)";

   $stmt = $pdo->prepare($sql);
   $stmt->execute([
      $data['title'],
      $data['content'],
      $_SESSION['email'], // Email của admin đang đăng nhập
      $data['target_type']
   ]);

   $notificationId = $pdo->lastInsertId();

   // Nếu là specific target, thêm vào bảng notification_targets
   if ($data['target_type'] === 'specific' && !empty($data['target_emails'])) {
      $emails = array_map('trim', explode(',', $data['target_emails']));

      $sql = "INSERT INTO notification_targets (notification_id, target_email) VALUES (?, ?)";
      $stmt = $pdo->prepare($sql);

      foreach ($emails as $email) {
         if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt->execute([$notificationId, $email]);
         }
      }
   }

   // Thêm vào bảng notification_recipients
   if ($data['target_type'] === 'all') {
      // Nếu gửi cho tất cả, lấy danh sách email từ bảng users
      $sql = "INSERT INTO notification_recipients (notification_id, recipient_email)
                SELECT ?, email FROM user WHERE status = 'active'";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$notificationId]);
   } else {
      // Nếu gửi cho specific users
      $sql = "INSERT INTO notification_recipients (notification_id, recipient_email)
                SELECT ?, target_email FROM notification_targets WHERE notification_id = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$notificationId, $notificationId]);
   }

   $pdo->commit();

   echo json_encode([
      'status' => 'success',
      'message' => 'Notification created successfully',
      'id' => $notificationId
   ]);
} catch (Exception $e) {
   if (isset($pdo)) {
      $pdo->rollBack();
   }
   echo json_encode([
      'status' => 'error',
      'message' => $e->getMessage()
   ]);
}
