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

      $state = $pdo->prepare('SELECT * FROM park');
      $state->execute();

      $park = [];

      foreach ($state as $row) {
         $park = new Park();
         $park->id = $row['id'];
         $park->name = $row['name'];
         $park->area = $row['area'];
         $park->location = $row['location'];
         $park->description = $row['description'];
         $park->thumbnail = $row['thumbnail'];

         $parks[] = $park;
      }

      return $parks;
   }

   public static function getFeatureParks(): array
   {
      $pdo = Database::getConnection();

      //get lastest 5 park by update time
      $state = $pdo->prepare('SELECT * FROM park ORDER BY id DESC LIMIT 5');
      $state->execute();

      $park = [];

      foreach ($state as $row) {
         $park = new Park();
         $park->id = $row['id'];
         $park->name = $row['name'];
         $park->location = $row['location'];
         $park->description = $row['description'];
         $park->thumbnail = $row['thumbnail'];

         $featureparks[] = $park;
      }

      return $featureparks;
   }

   public static function getPark(int|string $id): ?Park
   {
      $pdo = Database::getConnection();

      $state = $pdo->prepare('SELECT * FROM parks WHERE id = :id');
      $state->execute(['id' => $id]);

      $row = $state->fetch();

      if (is_null($row)) {
         return null;
      }

      $park = new Park();
      $park->id = $row['id'];
      $park->name = $row['name'];
      $park->area = $row['area'];
      $park->location = $row['location'];
      $park->description = $row['description'];
      $park->thumbnail = $row['thumbnail'];

      return $park;
   }
}
