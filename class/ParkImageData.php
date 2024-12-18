<?php 

class ParkImageData {
   public static function getParkImages(int|string $id): array
   {
      $pdo = Database::getConnection();

      $state = $pdo->prepare('SELECT * FROM park_images WHERE id = :id');
      $state->execute(['id' => $id]);

      $parkImages = [];

      foreach ($state as $row) {
         $parkImage = new ParkImage();
         $parkImage->id = $row['id'];
         $parkImage->id = $row['id'];
         $parkImage->image = $row['image'];

         $parkImages[] = $parkImage;
      }

      return $parkImages;
   }
}