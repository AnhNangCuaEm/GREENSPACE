<?php
require_once __DIR__ . '/../../class/Database.php';

try {
   $pdo = Database::getConnection();

   // Add error mode setting
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $sql = "SELECT * FROM feedback ORDER BY created_at DESC";

   $stmt = $pdo->prepare($sql);
   $stmt->execute();
   $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

   // Add debug information
   if (empty($feedbacks)) {
       echo json_encode([
           'status' => 'empty',
           'message' => 'No feedbacks found',
           'data' => []
       ]);
   } else {
       echo json_encode([
           'status' => 'success',
           'count' => count($feedbacks),
           'data' => $feedbacks
       ]);
   }
} catch (PDOException $e) {
   echo json_encode([
       'status' => 'error',
       'message' => $e->getMessage(),
       'code' => $e->getCode()
   ]);
}
