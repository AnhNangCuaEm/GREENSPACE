<?php
require_once __DIR__ . '/class/ParkData.php';
require_once __DIR__ . '/functions/verify.php';

session_start();

$parks = ParkData::getallParks();

$email = verifyToken(); // Kiểm tra token trong cookie
if (!$email) {
   header('Location: login.php'); // Chuyển hướng nếu token không hợp lệ
   exit();
}

// Nếu cần, lưu lại email trong session để dùng trong phiên hiện tại
$_SESSION['email'] = $email;

?>

<html>

<head>
   <?php include 'include/head.php' ?>
</head>

<body>
   <div id="content">
      <?php include 'include/nav.php' ?>
      <main>
         <h1>公園一覧</h1>
         <div class="park-container">
            <?php foreach ($parks as $park): ?>
               <div class="park-box">
                  <a href="park.php?id=<?= $park->id ?>"><img src="<?= $park->thumbnail ?>"></a>
                  <div class="name"><?= $park->name ?></div>
                  <div class="location"><?= $park->location ?></div>
               </div>
            <?php endforeach; ?>
         </div>
      </main>
      <div id="overlay"></div>
      <footer>
         <?php include 'include/footer.php' ?>
      </footer>
   </div>
   <script src="js/menu.js"></script>
   <script src="js/search.js"></script>
</body>

</html>