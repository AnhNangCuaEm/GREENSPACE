<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../class/ParkData.php';
require_once __DIR__ . '/../class/EventData.php';

try {
    // Ensure query parameter exists
    if (!isset($_GET['query'])) {
        throw new Exception('Query parameter is required');
    }

    $query = $_GET['query'];
    $results = [];

    if (strlen($query) >= 1) {
        // Wrap database operations in try-catch
        try {
            //Search in parks
            $parks = ParkData::searchParks($query);
            foreach ($parks as $park) {
                $results[] = [
                    'id' => $park->id,
                    'name' => $park->name,
                    'type' => 'park',
                    'thumbnail' => $park->thumbnail
                ];
            }

            //Search in events
            $events = EventData::searchEvents($query);
            foreach ($events as $event) {
                $results[] = [
                    'id' => $event->id,
                    'name' => $event->name,
                    'type' => 'event',
                    'thumbnail' => $event->thumbnail
                ];
            }
        } catch (Exception $e) {
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }

    header('Content-Type: application/json');
    echo json_encode($results);
    
} catch (Exception $e) {
    // Return error as JSON
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}