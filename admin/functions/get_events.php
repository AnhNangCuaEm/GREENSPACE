<?php
require_once __DIR__ . '/../../class/EventData.php';

header('Content-Type: application/json');

try {
   $events = EventData::getAllEvents();
   echo json_encode($events);
} catch (Exception $e) {
   echo json_encode(['error' => $e->getMessage()]);
}
