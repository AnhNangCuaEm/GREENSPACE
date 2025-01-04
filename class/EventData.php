<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Event.php';

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
      
      $state = $pdo->prepare('SELECT * FROM event WHERE name LIKE :query OR location LIKE :query LIMIT 5');
      $state->execute(['query' => "%$query%"]);
      
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
