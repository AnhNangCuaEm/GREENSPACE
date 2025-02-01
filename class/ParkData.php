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

   public static function getallParks(bool $randomOrder = false): array
   {
      $pdo = Database::getConnection();

      $sql = 'SELECT * FROM park ORDER BY ' . ($randomOrder ? 'RAND()' : 'id ASC');
      $state = $pdo->prepare($sql);
      $state->execute();

      $parks = [];

      foreach ($state as $row) {
         $park = new Park();
         $park->id = $row['id'];
         $park->name = $row['name'];
         $park->thumbnail = $row['thumbnail'];
         $park->location = $row['location'];
         $park->area = $row['area'];
         $park->price = $row['price'];
         $park->nearest = $row['nearest'];
         $park->special = $row['special'];
         $park->description = $row['description'];
         $park->map = $row['map'];
         $park->parkfeature = $row['parkfeature'];

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

      if (!$row) {
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
      $park->parkfeature = $row['parkfeature'];
      $park->name_yomi = $row['name_yomi'];
      $park->location_yomi = $row['location_yomi'];
      $park->name_romaji = $row['name_romaji'];
      $park->location_romaji = $row['location_romaji'];
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

   public static function addPark($name, $location, $area, $price, $nearest, $special, $description, $thumbnail, $map, $name_yomi, $location_yomi, $name_romaji, $location_romaji, $parkfeature): bool
   {
      $pdo = Database::getConnection();
      $sql = "INSERT INTO park (name, location, area, price, nearest, special, description, thumbnail, map, name_yomi, location_yomi, name_romaji, location_romaji, parkfeature) 
              VALUES (:name, :location, :area, :price, :nearest, :special, :description, :thumbnail, :map, :name_yomi, :location_yomi, :name_romaji, :location_romaji, :parkfeature)";

      $state = $pdo->prepare($sql);
      return $state->execute([
         'name' => $name,
         'location' => $location,
         'area' => $area,
         'price' => $price,
         'nearest' => $nearest,
         'special' => $special,
         'description' => $description,
         'thumbnail' => $thumbnail,
         'map' => $map,
         'parkfeature' => $parkfeature,
         'name_yomi' => $name_yomi,
         'location_yomi' => $location_yomi,
         'name_romaji' => $name_romaji,
         'location_romaji' => $location_romaji
      ]);
   }

   public static function updatePark($id, $name, $location, $area, $price, $nearest, $special, $description, $thumbnail, $map, $parkfeature, $name_yomi, $location_yomi, $name_romaji, $location_romaji): bool
   {
      $pdo = Database::getConnection();
      $sql = "UPDATE park 
              SET name = :name, 
                  location = :location, 
                  area = :area, 
                  price = :price, 
                  nearest = :nearest, 
                  special = :special, 
                  description = :description, 
                  thumbnail = :thumbnail, 
                  map = :map,
                  parkfeature = :parkfeature,
                  name_yomi = :name_yomi,
                  location_yomi = :location_yomi,
                  name_romaji = :name_romaji,
                  location_romaji = :location_romaji
              WHERE id = :id";

      $state = $pdo->prepare($sql);
      return $state->execute([
         'id' => $id,
         'name' => $name,
         'location' => $location,
         'area' => $area,
         'price' => $price,
         'nearest' => $nearest,
         'special' => $special,
         'description' => $description,
         'thumbnail' => $thumbnail,
         'map' => $map,
         'parkfeature' => $parkfeature,
         'name_yomi' => $name_yomi,
         'location_yomi' => $location_yomi,
         'name_romaji' => $name_romaji,
         'location_romaji' => $location_romaji
      ]);
   }

   public static function deletePark($id): bool
   {
      try {
         $pdo = Database::getConnection();
         
         // Bắt đầu transaction
         $pdo->beginTransaction();
         
         // Xóa các bản ghi liên quan trong bảng park_likes
         $sql1 = "DELETE FROM park_likes WHERE park_id = :id";
         $state1 = $pdo->prepare($sql1);
         $state1->execute(['id' => $id]);
         
         // Xóa các bản ghi liên quan trong bảng park_images
         $sql2 = "DELETE FROM park_images WHERE park_id = :id";
         $state2 = $pdo->prepare($sql2);
         $state2->execute(['id' => $id]);
         
         // Xóa công viên
         $sql3 = "DELETE FROM park WHERE id = :id";
         $state3 = $pdo->prepare($sql3);
         $result = $state3->execute(['id' => $id]);
         
         if ($result) {
            $pdo->commit();
            return true;
         } else {
            $pdo->rollBack();
            return false;
         }
      } catch (PDOException $e) {
         if (isset($pdo)) {
            $pdo->rollBack();
         }
         throw new Exception("Database error: " . $e->getMessage());
      }
   }
}
