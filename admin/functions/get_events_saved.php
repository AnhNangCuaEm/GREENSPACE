<?php
require_once __DIR__ . '/../../class/Database.php';
require_once __DIR__ . '/../../functions/verify.php';

session_start();

// Verify admin access
$email = verifyToken();
if (!$email) {
   http_response_code(401);
   exit('Unauthorized');
}

try {
   $db = new Database();
   $conn = $db->getConnection();

   // Get top 10 most saved events with event names
   $query = "SELECT e.name, COUNT(es.event_id) as saves_count 
             FROM event_saved es
             JOIN event e ON es.event_id = e.id 
             GROUP BY es.event_id, e.name 
             ORDER BY saves_count DESC 
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
