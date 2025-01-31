<?php
require_once __DIR__ . '/../../class/Database.php';

header('Content-Type: application/json');

try {
   $pdo = Database::getConnection();

   // Get search term from query parameter
   $term = isset($_GET['term']) ? $_GET['term'] : '';

   if (empty($term)) {
      echo json_encode([]);
      exit;
   }

   // Search users by email
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
