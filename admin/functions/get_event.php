<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/EventData.php';

checkAdmin();

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
