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
         // Trả về cả id và image_url
         $parkImages[] = [
            'id' => $row['id'],
            'image_url' => $row['image_url']
         ];
      }

      return $parkImages;
   }

   /**
    * Thêm ảnh mới cho công viên
    * 
    * @param int|string $parkId ID của công viên
    * @param string $imageUrl Đường dẫn ảnh
    * @return bool Kết quả thêm ảnh
    */
   public static function addParkImage(int|string $parkId, string $imageUrl): bool
   {
      $pdo = Database::getConnection();
      $stmt = $pdo->prepare('INSERT INTO park_images (park_id, image_url) VALUES (:park_id, :image_url)');
      return $stmt->execute([
         'park_id' => $parkId,
         'image_url' => $imageUrl
      ]);
   }

   /**
    * Cập nhật đường dẫn ảnh
    * 
    * @param int|string $imageId ID của ảnh
    * @param string $newImageUrl Đường dẫn ảnh mới
    * @return bool Kết quả cập nhật
    */
   public static function updateParkImage(int|string $imageId, string $newImageUrl): bool
   {
      $pdo = Database::getConnection();
      $stmt = $pdo->prepare('UPDATE park_images SET image_url = :image_url WHERE id = :id');
      return $stmt->execute([
         'id' => $imageId,
         'image_url' => $newImageUrl
      ]);
   }

   /**
    * Xóa ảnh khỏi công viên
    * 
    * @param int|string $imageId ID của ảnh cần xóa
    * @return bool Kết quả xóa ảnh
    */
   public static function deleteParkImage(int|string $imageId): bool
   {
      $pdo = Database::getConnection();
      $stmt = $pdo->prepare('DELETE FROM park_images WHERE id = :id');
      return $stmt->execute(['id' => $imageId]);
   }

   /**
    * Xóa ảnh khỏi công viên
    * 
    * @param string $imageUrl Đường dẫn ảnh cần xóa
    * @return bool Kết quả xóa ảnh
    */
   public static function deleteParkImageByUrl(string $imageUrl): bool
   {
      $pdo = Database::getConnection();
      $stmt = $pdo->prepare('DELETE FROM park_images WHERE image_url = :image_url');
      return $stmt->execute(['image_url' => $imageUrl]);
   }
}
