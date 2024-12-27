<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ParkImage.php';

class ParkImageData
{
   /**
    * Lấy danh sách ảnh liên quan đến park_id
    * 
    * @param int|string $id ID của công viên (park)
    * @return string[] Danh sách các đường dẫn ảnh
    */
   public static function getParkImages(int|string $id): array
   {
      $pdo = Database::getConnection();

      $state = $pdo->prepare('SELECT * FROM park_images WHERE park_id = :id');

      $state->execute(['id' => $id]);

      // Khởi tạo mảng chứa danh sách ảnh
      $parkImages = [];

      // Lặp qua các kết quả và chỉ lấy đường dẫn ảnh
      while ($row = $state->fetch(PDO::FETCH_ASSOC)) {
         // Chỉ thêm đường dẫn ảnh vào mảng
         $parkImages[] = $row['image_url']; // Chỉ lấy đường dẫn ảnh
      }

      return $parkImages;
   }
}
