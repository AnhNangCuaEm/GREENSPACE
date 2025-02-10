<?php
require_once __DIR__ . '/class/ParkData.php';
require_once __DIR__ . '/functions/verify.php';
require_once __DIR__ . '/functions/track_visits.php';

session_start();

$parks = ParkData::getallParks(true);

$email = verifyToken();
if (!$email) {
   header('Location: login.php');
   exit();
}

$_SESSION['email'] = $email;

trackPageVisit('all.php');
?>

<!DOCTYPE html>
<html lang="ja">

<head>
   <?php include 'include/head.php' ?>
</head>

<body>
   <div class="gradient-bg">
      <svg xmlns="http://www.w3.org/2000/svg">
         <defs>
            <filter id="goo">
               <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
               <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -8" result="goo" />
               <feBlend in="SourceGraphic" in2="goo" />
            </filter>
         </defs>
      </svg>
      <div class="gradients-container">
         <div class="g1"></div>
         <div class="g2"></div>
         <div class="interactive"></div>
      </div>
   </div>
   <div class="content-wrapper">
         <?php include 'include/nav.php' ?>
         <main>
            <h1>公園一覧</h1>
            <div class="park-container">
               <?php foreach ($parks as $park): ?>
                  <div class="park-box">
                     <div class="image-container loading">
                        <a href="park.php?id=<?= $park->id ?>">
                           <img src="<?= $park->thumbnail ?>" onload="this.classList.add('loaded'); this.parentElement.parentElement.classList.remove('loading')">
                        </a>
                     </div>
                     <div class="park-text">
                        <div class="name"><?= $park->name ?></div>
                        <div class="location"><span>住所:</span>&nbsp;<?= $park->location ?></div>
                        <div class="price"><span>料金:</span>&nbsp;<?= $park->price ?></div>
                        <div class="nearest"><span>最寄り駅:</span>&nbsp;<?= $park->nearest ?></div>
                        <div class="special"><span>特別な特徴:</span>&nbsp;<?= $park->special ?></div>
                     </div>
                  </div>
               <?php endforeach; ?>
            </div>
         </main>
         <div id="overlay"></div>
         <footer>
            <?php include 'include/footer.php' ?>
         </footer>
   </div>
   <script src="js/background.js"></script>
   <script src="js/menu.js"></script>
   <script src="js/search.js"></script>
   <script src="js/scroll-animation.js"></script>
</body>

</html>