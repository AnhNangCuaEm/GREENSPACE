<?php
session_start();
require_once __DIR__ . '/../../class/Database.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
   header('Content-Type: application/json');
   http_response_code(403);
   echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
   exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $data = json_decode(file_get_contents('php://input'), true);
   $id = $data['id'] ?? null;

   if ($id) {
      try {
         $pdo = Database::getConnection();
         $sql = "DELETE FROM feedback WHERE id = :id";
         $stmt = $pdo->prepare($sql);
         $stmt->execute([':id' => $id]);

         echo json_encode(['success' => true]);
      } catch (PDOException $e) {
         echo json_encode(['error' => $e->getMessage()]);
      }
   }
}
