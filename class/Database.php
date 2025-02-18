<?php

require_once __DIR__ . '/../env.php';

if (!class_exists('Database')) {
   class Database
   {
      private static $connection = null;
      
      public static function getConnection(): PDO
      {
         if (self::$connection === null) {
            self::$connection = new PDO(
               'mysql:charset=UTF8;dbname=' . DB_DATABASE . ';host=' . DB_HOST . ';port=' . DB_PORT,
               DB_USER,
               DB_PASSWORD
            );
            self::$connection->exec("SET time_zone = 'Asia/Tokyo'");
         }
         return self::$connection;
      }
   }
}
