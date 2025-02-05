<?php
// Disable error display on output
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Set JSON header right from the start
header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../class/ParkData.php';
    require_once __DIR__ . '/../class/EventData.php';
    require_once __DIR__ . '/../functions/TextHelper.php';

    // Ensure query parameter exists
    if (!isset($_GET['query'])) {
        throw new Exception('Query parameter is required');
    }

    $query = $_GET['query'];
    error_log("Original query: " . $query); // Debug log

    $results = [];

    if (strlen($query) >= 1) {
        try {
            //Search in parks
            error_log("Searching parks..."); // Debug log
            $parks = ParkData::searchParks($query);
            error_log("Found " . count($parks) . " parks"); // Debug log

            foreach ($parks as $park) {
                $results[] = [
                    'id' => $park->id,
                    'name' => $park->name,
                    'type' => 'park',
                    'thumbnail' => $park->thumbnail
                ];
            }

            //Search in events
            error_log("Searching events..."); // Debug log
            $events = EventData::searchEvents($query);
            error_log("Found " . count($events) . " events"); // Debug log

            foreach ($events as $event) {
                $results[] = [
                    'id' => $event->id,
                    'name' => $event->name,
                    'type' => 'event',
                    'thumbnail' => $event->thumbnail
                ];
            }
        } catch (Throwable $e) {
            error_log("Search error: " . $e->getMessage()); // Debug log
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }

    error_log("Total results: " . count($results)); // Debug log
    echo json_encode($results);
    
} catch (Throwable $e) {
    error_log("General error: " . $e->getMessage()); // Debug log
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}