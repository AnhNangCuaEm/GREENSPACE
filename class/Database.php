<?php

require_once __DIR__ . '/../env.php';

if (!class_exists('Database')) {
   class Database
   {
      public static function getConnection(): PDO
      {
         $pdo = new PDO(
            'mysql:charset=UTF8;dbname=' . DB_DATABASE . ';host=' . DB_HOST . ';port=' . DB_PORT,
            DB_USER,
            DB_PASSWORD,
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone='+09:00'"]
         );
         return $pdo;
      }
   }
}
