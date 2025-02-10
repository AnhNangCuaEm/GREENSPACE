<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/EventData.php';

checkAdmin();

header('Content-Type: application/json');

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
