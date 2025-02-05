<?php
session_start();
require_once __DIR__ . '/../../class/Database.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
   header('Content-Type: application/json');
   http_response_code(403);
   echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
   exit();
}
header('Content-Type: application/json');

try {
   $pdo = Database::getConnection();

   // Get search term from query parameter
   $term = isset($_GET['term']) ? $_GET['term'] : '';

   if (empty($term)) {
      echo json_encode([]);
      exit;
   }

   $sql = "SELECT email FROM user 
            WHERE email LIKE :term 
            AND status = 'active' 
            ORDER BY email 
            LIMIT 10";

   $stmt = $pdo->prepare($sql);
   $stmt->execute([
      ':term' => "%{$term}%"
   ]);

   $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

   echo json_encode($users);
} catch (PDOException $e) {
   http_response_code(500);
   echo json_encode([
      'error' => 'Database error',
      'message' => $e->getMessage()
   ]);
}
