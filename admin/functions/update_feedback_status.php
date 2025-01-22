<?php
require_once __DIR__ . '/../../class/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $data = json_decode(file_get_contents('php://input'), true);
   $id = $data['id'] ?? null;
   $field = $data['field'] ?? null;
   $value = $data['value'] ?? null;

   // Validate field name to prevent SQL injection
   $allowedFields = ['is_read', 'is_important'];
   if (!in_array($field, $allowedFields)) {
      echo json_encode(['success' => false, 'message' => 'Invalid field']);
      exit;
   }

   try {
      $pdo = Database::getConnection();
      $sql = "UPDATE feedback SET $field = :value WHERE id = :id";
      $stmt = $pdo->prepare($sql);
      $result = $stmt->execute([
         ':value' => $value ? 1 : 0, // Convert boolean to integer
         ':id' => $id
      ]);

      if ($result) {
         echo json_encode(['success' => true]);
      } else {
         echo json_encode(['success' => false, 'message' => 'Update failed']);
      }
   } catch (PDOException $e) {
      error_log("Database error: " . $e->getMessage());
      echo json_encode(['success' => false, 'message' => 'Database error']);
   }
} else {
   echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
