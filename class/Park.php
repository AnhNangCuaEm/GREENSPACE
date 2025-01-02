<?php 

require_once __DIR__ . '/ParkImage.php';

class Park {
   public int $id;
   public string $name;
   public string $area;
   public string $location;
   public string $price;
   public string $description;
   public string $thumbnail;
   /**
    * @var ParkImage[]
    */
   public array $images;
   public string $map;
   public string $nearest;
   public string $special;
}