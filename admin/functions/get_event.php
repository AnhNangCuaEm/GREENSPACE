<?php
require_once __DIR__ . '/../../class/EventData.php';

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
