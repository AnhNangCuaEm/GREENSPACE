<?php
require_once __DIR__ . '/class/ParkData.php';

$parks = ParkData::getParks();

?>

<html>
<?php include 'include/head.php' ?>

<body>
   <!-- tắt tạm trang loading trong lúc đang code -->
   <!-- <div id="loading">
      <img src="img/img/logo.png" alt="">
   </div> -->
   <div id="content">
      <?php include 'include/nav.php' ?>
      <main>
         <div class="slideshow-container">
            <div id="slideshow-area" class="slideshow-area">
            <?php foreach ($parks as $park) : ?>
               <div class="mySlides">
                  <a href="park.php?id=<?= $park->id ?>"><img src="<?= $park->thumbnail ?>"></a>
                  <div class="name"><?= $park->name ?></div>
                  <div class="description"><?= $park->description ?></div>
               </div>
            <?php endforeach; ?>
            </div>
            

            <a class="prev" onclick="prev()"><svg fill="#fcf8db" height="15px" width="15px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 55.753 55.753" xml:space="preserve">
                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                  <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                  <g id="SVGRepo_iconCarrier">
                     <g>
                        <path d="M12.745,23.915c0.283-0.282,0.59-0.52,0.913-0.727L35.266,1.581c2.108-2.107,5.528-2.108,7.637,0.001 c2.109,2.108,2.109,5.527,0,7.637L24.294,27.828l18.705,18.706c2.109,2.108,2.109,5.526,0,7.637 c-1.055,1.056-2.438,1.582-3.818,1.582s-2.764-0.526-3.818-1.582L13.658,32.464c-0.323-0.207-0.632-0.445-0.913-0.727 c-1.078-1.078-1.598-2.498-1.572-3.911C11.147,26.413,11.667,24.994,12.745,23.915z"></path>
                     </g>
                  </g>
               </svg></a>
            <a class="next" onclick="next()"><svg fill="#fcf8db" height="15px" width="15px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 55.752 55.752" xml:space="preserve">
                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                  <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                  <g id="SVGRepo_iconCarrier">
                     <g>
                        <path d="M43.006,23.916c-0.28-0.282-0.59-0.52-0.912-0.727L20.485,1.581c-2.109-2.107-5.527-2.108-7.637,0.001 c-2.109,2.108-2.109,5.527,0,7.637l18.611,18.609L12.754,46.535c-2.11,2.107-2.11,5.527,0,7.637c1.055,1.053,2.436,1.58,3.817,1.58 s2.765-0.527,3.817-1.582l21.706-21.703c0.322-0.207,0.631-0.444,0.912-0.727c1.08-1.08,1.598-2.498,1.574-3.912 C44.605,26.413,44.086,24.993,43.006,23.916z"></path>
                     </g>
                  </g>
               </svg></a>

            <div class="slideDot-container" id="slideDot-container">
               <span class="dot" onclick="currentSlide(1)"></span>
               <span class="dot" onclick="currentSlide(2)"></span>
               <span class="dot" onclick="currentSlide(3)"></span>
               <span class="dot" onclick="currentSlide(4)"></span>
               <span class="dot" onclick="currentSlide(5)"></span>
            </div>
         </div>

      </main>
   </div>
   <script src="js/index.js"></script>
</body>

</html>