<?php
// Disable error display on output
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Set JSON header right from the start
header('Content-Type: application/json');

// Đầu file
error_log("[Search] Starting search process");

try {
    require_once __DIR__ . '/../class/ParkData.php';
    require_once __DIR__ . '/../class/EventData.php';
    require_once __DIR__ . '/../functions/TextHelper.php';

    // Ensure query parameter exists
    if (!isset($_GET['query'])) {
        error_log("[Search] No query parameter");
        throw new Exception('Query parameter is required');
    }

    $query = $_GET['query'];
    error_log("[Search] Query: " . $query); // Debug log

    $results = [];

    if (strlen($query) >= 1) {
        try {
            //Search in parks
            error_log("[Search] Starting park search");
            $parks = ParkData::searchParks($query);
            error_log("[Search] Found " . count($parks) . " parks"); // Debug log

            foreach ($parks as $park) {
                $results[] = [
                    'id' => $park->id,
                    'name' => $park->name,
                    'type' => 'park',
                    'thumbnail' => $park->thumbnail
                ];
            }

            //Search in events
            error_log("[Search] Starting event search");
            $events = EventData::searchEvents($query);
            error_log("[Search] Found " . count($events) . " events"); // Debug log

            foreach ($events as $event) {
                $results[] = [
                    'id' => $event->id,
                    'name' => $event->name,
                    'type' => 'event',
                    'thumbnail' => $event->thumbnail
                ];
            }

            // Log the SQL query in EventData
            error_log("[Search] Total results: " . (count($parks) + count($events)));

        } catch (Throwable $e) {
            error_log("[Search] Database error: " . $e->getMessage());
            error_log("[Search] Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    error_log("Total results: " . count($results)); // Debug log
    echo json_encode($results);
    
} catch (Throwable $e) {
    error_log("[Search] Fatal error: " . $e->getMessage());
    error_log("[Search] Stack trace: " . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}