<?php

$host = getenv('DB_HOST');
$dbname = getenv('DB_DATABASE');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

try {
   $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

   $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
   ];

   $pdo = new PDO($dsn, $username, $password, $options);
   echo "接続成功!";
} catch (PDOException $e) {
   echo "接続エラー: " . $e->getMessage();
}
