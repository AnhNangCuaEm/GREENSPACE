<?php
session_start();
require_once __DIR__ . '/../../class/Database.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
   http_response_code(403);
   echo json_encode([
      'success' => false,
      'message' => 'Unauthorized access'
   ]);
   exit;
}

header('Content-Type: application/json');

try {
   $data = json_decode(file_get_contents('php://input'), true);

   if (!isset($data['title']) || !isset($data['content']) || !isset($data['target_type'])) {
      throw new Exception('Missing required fields: ' . 
         'title=' . isset($data['title']) . 
         ', content=' . isset($data['content']) . 
         ', target_type=' . isset($data['target_type']));
   }

   $pdo = Database::getConnection();
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $pdo->beginTransaction();

   try {
      // Add new notification
      $sql = "INSERT INTO notifications (title, content, created_by, target_type, created_at, is_active) 
               VALUES (?, ?, ?, ?, NOW(), 0)";

      $stmt = $pdo->prepare($sql);
      $stmt->execute([
         $data['title'],
         $data['content'],
         $_SESSION['email'],
         $data['target_type']
      ]);

      $notificationId = $pdo->lastInsertId();

      // If specific target, add to notification_targets
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

      $pdo->commit();

      echo json_encode([
         'success' => true,
         'message' => 'Notification created successfully',
         'id' => $notificationId
      ]);

   } catch (PDOException $e) {
      $pdo->rollBack();
      throw new Exception('Database error: ' . $e->getMessage());
   }

} catch (Exception $e) {
   error_log("Error in create_notification.php: " . $e->getMessage());
   http_response_code(500);
   echo json_encode([
      'success' => false,
      'message' => $e->getMessage()
   ]);
}
