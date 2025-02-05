<?php
session_start();
require_once __DIR__ . '/../../class/EventData.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
   header('Content-Type: application/json');
   http_response_code(403);
   echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
   exit();
}
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
   echo json_encode(['error' => 'Event ID is required']);
   exit;
}

try {
   $event = EventData::getEventById($_GET['id']);
   echo json_encode($event);
} catch (Exception $e) {
   echo json_encode(['error' => $e->getMessage()]);
}
