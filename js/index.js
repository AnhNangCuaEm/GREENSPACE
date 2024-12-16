// document.addEventListener("DOMContentLoaded", function () {
//    const loadingDiv = document.getElementById("loading");
//    const contentDiv = document.getElementById("content");

//    // Ẩn nội dung khi trang bắt đầu tải
//    contentDiv.style.display = "none";

//    // Khi toàn bộ nội dung đã tải xong
//    window.onload = function () {
//       // Ẩn div loading
//       loadingDiv.style.display = "none";

//       // Hiển thị nội dung chính
//       contentDiv.style.display = "block";
//    };
// });


//hiện tối thiểu 1s
document.addEventListener("DOMContentLoaded", function () {
   const loadingDiv = document.getElementById("loading");
   const contentDiv = document.getElementById("content");

   // Ẩn nội dung khi trang bắt đầu tải
   contentDiv.style.display = "none";

   // Bắt đầu thời gian tải tối thiểu
   const minLoadTime = 1000; // 1 giây
   const startTime = Date.now();

   // Khi toàn bộ nội dung đã tải xong
   window.onload = function () {
      const elapsedTime = Date.now() - startTime;
      const remainingTime = minLoadTime - elapsedTime;

      // Đảm bảo loading hiển thị tối thiểu 1 giây
      setTimeout(() => {
         // Ẩn div loading
         loadingDiv.style.display = "none";

         // Hiển thị nội dung chính
         contentDiv.style.display = "block";
      }, Math.max(remainingTime, 0));
   };
});

// Hamburger menu
const hamburger = document.getElementById('hamburger');

hamburger.addEventListener('click', () => {
   hamburger.classList.toggle('active');
});


/* Slideshow JavaScript */
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
   showSlides(slideIndex += n);
}

function currentSlide(n) {
   showSlides(slideIndex = n);
}

function showSlides(n) {
   var i;
   var slides = document.getElementsByClassName("mySlides");
   var dots = document.getElementsByClassName("dot");
   if (n > slides.length) { slideIndex = 1 }
   if (n < 1) { slideIndex = slides.length };
   for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
   }
   for (i = 0; i < dots.length; i++) {
      dots[i].classList.remove("active");
   }
   slides[slideIndex - 1].style.display = "block";
   dots[slideIndex - 1].classList.add("active");
}
/* Slideshow JavaScript */