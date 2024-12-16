<?php

require_once __DIR__ . '/../env.php';

class Database
{
   public static function getConnection(): PDO
   {
      return new PDO(
         'mysql:charset=UTF8;dbname=' . DB_DATABASE . ';host=' . DB_HOST,
         DB_USER,
         DB_PASSWORD
      );
   }
}
