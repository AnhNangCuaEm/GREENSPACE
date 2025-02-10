<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/Database.php';

session_start();

checkAdmin();

try {
   $db = new Database();
   $conn = $db->getConnection();

   //もしニックネームがあればそれを表示し、なければユーザーのメールアドレスを表示する
   $query = "SELECT c.*, p.name as park_name, 
              CASE 
                  WHEN c.nickname IS NOT NULL AND c.nickname != '' THEN c.nickname 
                  ELSE c.user_email 
              END as display_name,
              DATE_FORMAT(c.created_at, '%Y-%m-%d %H:%i') as formatted_date
              FROM comments c
              JOIN park p ON c.park_id = p.id 
              ORDER BY c.created_at DESC 
              LIMIT 6";

   $stmt = $conn->prepare($query);
   $stmt->execute();
   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   header('Content-Type: application/json');
   echo json_encode($results);
} catch (PDOException $e) {
   http_response_code(500);
   echo json_encode(['error' => $e->getMessage()]);
}
