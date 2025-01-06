<?php

class Database {
   public static function getConnection(): PDO {
      return new PDO(
         'mysql:charset=UTF8;dbname=' . getenv('DB_DATABASE') . ';host=' . getenv('DB_HOST'),
         getenv('DB_USERNAME'),
         getenv('DB_PASSWORD')
      );
   }
}
