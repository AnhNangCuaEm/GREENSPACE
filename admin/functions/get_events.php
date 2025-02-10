<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/EventData.php';

checkAdmin();

header('Content-Type: application/json');

try {
   $events = EventData::getAllEvents();
   echo json_encode($events);
} catch (Exception $e) {
   echo json_encode(['error' => $e->getMessage()]);
}
