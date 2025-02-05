<?php
require_once __DIR__ . '/../class/ParkData.php';
require_once __DIR__ . '/../class/EventData.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $results = [];

    if (strlen($query) >= 1) { //Only search when there is at least 1 character
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
    }

    header('Content-Type: application/json');
    echo json_encode($results);
}