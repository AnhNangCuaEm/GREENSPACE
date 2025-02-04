<?php
session_start();
require_once __DIR__ . '/../../class/EventData.php';

header('Content-Type: application/json');

// Kiểm tra quyền admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
   header('Content-Type: application/json');
   http_response_code(403);
   echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
   exit();
}
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
   echo json_encode(['success' => false, 'message' => 'Invalid data']);
   exit;
}

try {
   $result = EventData::addEvent(
      $data['name'],
      $data['location'],
      $data['date'],
      $data['time'],
      $data['price'],
      $data['description'],
      $data['thumbnail']
   );

   echo json_encode(['success' => true]);
} catch (Exception $e) {
   echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
