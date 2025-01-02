<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Park.php';
require_once __DIR__ . '/ParkImageData.php';

class parkData
{
   /**
    * @return Park[]
    */
   public static function getParks(): array
   {
      $pdo = Database::getConnection();

      $state = $pdo->prepare('SELECT * FROM park ORDER BY RAND() LIMIT 8');
      $state->execute();

      $park = [];

      foreach ($state as $row) {
         $park = new Park();
         $park->id = $row['id'];
         $park->name = $row['name'];
         $park->location = $row['location'];
         $park->thumbnail = $row['thumbnail'];

         $parks[] = $park;
      }

      return $parks;
   }

   public static function getallParks(): array
   {
      $pdo = Database::getConnection();

      $state = $pdo->prepare('SELECT * FROM park ORDER BY RAND()');
      $state->execute();

      $park = [];

      foreach ($state as $row) {
         $park = new Park();
         $park->id = $row['id'];
         $park->name = $row['name'];
         $park->area = $row['area'];
         $park->location = $row['location'];
         $park->thumbnail = $row['thumbnail'];

         $parks[] = $park;
      }

      return $parks;
   }

   public static function getFeatureParks(): array
   {
      $pdo = Database::getConnection();

      //get lastest 5 park by update time
      $state = $pdo->prepare('SELECT * FROM park ORDER BY RAND() LIMIT 5');
      $state->execute();

      $park = [];

      foreach ($state as $row) {
         $park = new Park();
         $park->id = $row['id'];
         $park->name = $row['name'];
         $park->description = $row['description'];
         $park->thumbnail = $row['thumbnail'];

         $featureparks[] = $park;
      }

      return $featureparks;
   }

   public static function getPark(int|string $id): ?Park
   {
      $pdo = Database::getConnection();

      $state = $pdo->prepare('SELECT * FROM park WHERE id = :id');
      $state->execute(['id' => $id]);

      $row = $state->fetch();

      if (is_null($row)) {
         return null;
      }

      $park = new Park();
      $park->id = $row['id'];
      $park->name = $row['name'];
      $park->area = $row['area'];
      $park->price = $row['price'];
      $park->location = $row['location'];
      $park->description = $row['description'];
      $park->thumbnail = $row['thumbnail'];
      $park->map = $row['map'];
      $park->nearest = $row['nearest'];
      $park->special = $row['special'];

      return $park;
   }
}
