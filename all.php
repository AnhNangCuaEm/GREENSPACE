<?php
require_once __DIR__ . '/class/ParkData.php';

$parks = ParkData::getallParks();

?>

<html>
<?php include 'include/head.php' ?>

<body>
   <div id="content">
      <?php include 'include/nav.php' ?>
      <main>
         <h1>公園一覧</h1>
         <div class="park-container">
            <?php foreach ($parks as $park) : ?>
               <div class="park-box">
                  <a href="park.php?id=<?= $park->id ?>"><img src="<?= $park->thumbnail ?>"></a>
                  <div class="name"><?= $park->name ?></div>
               </div>
            <?php endforeach; ?>
         </div>
      </main>
      <?php include 'include/footer.php' ?>
   </div>
   <script src="js/menu.js"></script>
   <script src="js/index.js"></script>
</body>

</html>