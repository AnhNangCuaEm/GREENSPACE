<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/EventData.php';

checkAdmin();

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'])) {
   echo json_encode(['success' => false, 'message' => 'Event ID is required']);
   exit;
}

try {
   $result = EventData::deleteEvent($data['id']);
   echo json_encode(['success' => true]);
} catch (Exception $e) {
   echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
