<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Park.php';
require_once __DIR__ . '/ParkImageData.php';
require_once __DIR__ . '/../functions/TextHelper.php';

class parkData
{
   /**
    * @return Park[]
    */
   public static function getParks(): array
   {
      $pdo = Database::getConnection();

      $state = $pdo->prepare('SELECT * FROM park ORDER BY RAND() LIMIT 6');
      $state->execute();

      $park = [];

      foreach ($state as $row) {
         $park = new Park();
         $park->id = $row['id'];
         $park->name = $row['name'];
         $park->location = $row['location'];
         $park->thumbnail = $row['thumbnail'];
         $park->price = $row['price'];
         $park->nearest = $row['nearest'];
         $park->special = $row['special'];

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
         $park->thumbnail = $row['thumbnail'];
         $park->location = $row['location'];
         $park->price = $row['price'];
         $park->nearest = $row['nearest'];
         $park->special = $row['special'];


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
         $park->parkfeature = $row['parkfeature'];
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

   public static function searchParks($query)
   {
      $pdo = Database::getConnection();
      
      // Chuẩn bị các biến tìm kiếm
      list($searchQuery, $searchQueryNoSpaces) = TextHelper::convertToSearchableText($query);
      $queryNoSpaces = str_replace(' ', '', $query);
      
      // Tìm kiếm với nhiều điều kiện
      $sql = "SELECT * FROM park WHERE 
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
      
      $parks = [];

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

   public static function getAllParkIds(): array
   {
      $pdo = Database::getConnection();
      $sql = 'SELECT id FROM park ORDER BY id';
      $state = $pdo->prepare($sql);
      $state->execute();
      $parkIds = [];
      while ($row = $state->fetch()) {
         $parkIds[] = $row['id'];
      }
      return $parkIds;
   }
}
