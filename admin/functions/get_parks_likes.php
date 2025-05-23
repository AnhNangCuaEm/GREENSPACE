<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/Database.php';

session_start();

checkAdmin();


try {
   $db = new Database();
   $conn = $db->getConnection();

   // Get top 10 most liked parks with park names
   $query = "SELECT p.name, COUNT(pl.park_id) as likes_count 
             FROM park_likes pl
             JOIN park p ON pl.park_id = p.id 
             GROUP BY pl.park_id, p.name 
             ORDER BY likes_count DESC 
             LIMIT 10";

   $stmt = $conn->prepare($query);
   $stmt->execute();
   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   header('Content-Type: application/json');
   echo json_encode($results);
} catch (PDOException $e) {
   http_response_code(500);
   echo json_encode(['error' => $e->getMessage()]);
}
