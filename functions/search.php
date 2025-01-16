<?php
require_once __DIR__ . '/../class/ParkData.php';
require_once __DIR__ . '/../class/EventData.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $results = [];

    if (strlen($query) >= 1) { // Chỉ tìm kiếm khi có ít nhất 1 ký tự
        // Tìm trong parks
        $parks = ParkData::searchParks($query);
        foreach ($parks as $park) {
            $results[] = [
                'id' => $park->id,
                'name' => $park->name,
                'type' => 'park',
                'thumbnail' => $park->thumbnail
            ];
        }

        // Tìm trong events
        $events = EventData::searchEvents($query);
        foreach ($events as $event) {
            $results[] = [
                'id' => $event->id,
                'name' => $event->name,
                'type' => 'event',
                'thumbnail' => $event->thumbnail
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($results);
}