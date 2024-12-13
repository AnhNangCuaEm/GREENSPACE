<?php

// Lấy thông tin kết nối từ Environment Variables
$host = getenv('DB_HOST');
$dbname = getenv('DB_DATABASE');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

// Kiểm tra biến môi trường
if (!$host || !$dbname || !$username || !$password) {
   die("Biến môi trường chưa được thiết lập hoặc không đọc được!");
}

try {
   // Chuỗi kết nối (DSN)
   $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

   // Tùy chọn PDO với SSL
   $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt', // Đường dẫn tới chứng chỉ gốc
   ];

   // Tạo kết nối PDO
   $pdo = new PDO($dsn, $username, $password, $options);
   echo "接続成功!"; // Kết nối thành công
} catch (PDOException $e) {
   echo "接続エラー: " . $e->getMessage(); // Lỗi kết nối
}
