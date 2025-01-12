<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Event.php';
require_once __DIR__ . '/../functions/TextHelper.php';

class eventData
{
   /**
    * @return Event[]
    */
   public static function getEvents(): array
   {
      $pdo = Database::getConnection();

      $state = $pdo->prepare('SELECT * FROM event ORDER BY RAND() LIMIT 3');
      $state->execute();

      $event = [];

      foreach ($state as $row) {
         $event = new Event();
         $event->id = $row['id'];
         $event->name = $row['name'];
         $event->date = $row['date'];
         $event->time = $row['time'];
         $event->location = $row['location'];
         $event->description = $row['description'];
         $event->price = $row['price'];
         $event->thumbnail = $row['thumbnail'];

         $events[] = $event;
      }

      return $events;
   }

   public static function getAllEvents(): array
   {
      $pdo = Database::getConnection();

      $state = $pdo->prepare('SELECT * FROM event ORDER BY RAND()');
      $state->execute();

      $event = [];

      foreach ($state as $row) {
         $event = new Event();
         $event->id = $row['id'];
         $event->name = $row['name'];
         $event->date = $row['date'];
         $event->time = $row['time'];
         $event->location = $row['location'];
         $event->description = $row['description'];
         $event->price = $row['price'];
         $event->thumbnail = $row['thumbnail'];

         $events[] = $event;
      }

      return $events;
   }

   public static function getEvent(int|string $id): ?Event
   {
      $pdo = Database::getConnection();

      $state = $pdo->prepare('SELECT * FROM event WHERE id = :id');
      $state->execute(['id' => $id]);

      $row = $state->fetch();

      if (is_null($row)) {
         return null;
      }

      $event = new Event();
      $event->id = $row['id'];
      $event->name = $row['name'];
      $event->date = $row['date'];
      $event->time = $row['time'];
      $event->location = $row['location'];
      $event->description = $row['description'];
      $event->price = $row['price'];
      $event->thumbnail = $row['thumbnail'];

      return $event;
   }

   public static function searchEvents($query)
   {
      $pdo = Database::getConnection();
      
      // Chuẩn bị các biến tìm kiếm
      list($searchQuery, $searchQueryNoSpaces) = TextHelper::convertToSearchableText($query);
      $queryNoSpaces = str_replace(' ', '', $query);
      
      // Tìm kiếm với nhiều điều kiện
      $sql = "SELECT * FROM event WHERE 
              name LIKE :query 
              OR location LIKE :query
              OR REPLACE(name, ' ', '') LIKE :queryNoSpaces
              OR REPLACE(location, ' ', '') LIKE :queryNoSpaces
              OR name_yomi LIKE :searchQuery 
              OR location_yomi LIKE :searchQuery
              OR REPLACE(name_yomi, ' ', '') LIKE :searchQueryNoSpaces
              OR REPLACE(location_yomi, ' ', '') LIKE :searchQueryNoSpaces
              OR name_romaji LIKE :query
              OR location_romaji LIKE :query
              OR REPLACE(name_romaji, ' ', '') LIKE :queryNoSpaces
              OR REPLACE(location_romaji, ' ', '') LIKE :queryNoSpaces
              LIMIT 5";
              
      $state = $pdo->prepare($sql);
      $state->execute([
          'query' => "%$query%",
          'queryNoSpaces' => "%$queryNoSpaces%",
          'searchQuery' => "%$searchQuery%",
          'searchQueryNoSpaces' => "%$searchQueryNoSpaces%"
      ]);
      
      $events = [];

      foreach ($state as $row) {
         $event = new Event();
         $event->id = $row['id'];
         $event->name = $row['name'];
         $event->location = $row['location'];
         $event->thumbnail = $row['thumbnail'];

         $events[] = $event;
      }

      return $events;
   }
}
