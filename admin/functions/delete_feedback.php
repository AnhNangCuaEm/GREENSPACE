<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/Database.php';

checkAdmin();

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
