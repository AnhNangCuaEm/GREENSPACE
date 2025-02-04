<?php
session_start();
require_once __DIR__ . '/../../class/ParkData.php';
require_once __DIR__ . '/../../class/ParkImageData.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
   header('Content-Type: application/json');
   http_response_code(403);
   echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
   exit();
}
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
   echo json_encode(['error' => 'Park ID is required']);
   exit;
}

try {
   $park = ParkData::getPark($_GET['id']);
   $parkImages = ParkImageData::getParkImages($_GET['id']);

   // Chuyển đổi $park thành array và thêm images vào
   $parkArray = [
      'id' => $park->id,
      'name' => $park->name,
      'area' => $park->area,
      'price' => $park->price,
      'nearest' => $park->nearest,
      'special' => $park->special,
      'description' => $park->description,
      'location' => $park->location,
      'thumbnail' => $park->thumbnail,
      'images' => $parkImages,
      'parkfeature' => $park->parkfeature,
      'map' => $park->map,
      'name_yomi' => $park->name_yomi,
      'name_romaji' => $park->name_romaji,
      'location_yomi' => $park->location_yomi,
      'location_romaji' => $park->location_romaji
   ];

   echo json_encode($parkArray);
} catch (Exception $e) {
   echo json_encode(['error' => $e->getMessage()]);
}
