//tắt tạm trang loading lúc đang
//loading transition
// document.addEventListener("DOMContentLoaded", function () {
//    const loadingDiv = document.getElementById("loading");
//    const contentDiv = document.getElementById("content");

//    // Ẩn nội dung khi trang bắt đầu tải
//    contentDiv.style.display = "none";

//    // Bắt đầu thời gian tải tối thiểu
//    const minLoadTime = 1000; // 1 giây
//    const startTime = Date.now();

//    // Khi toàn bộ nội dung đã tải xong
//    window.onload = function () {
//       const elapsedTime = Date.now() - startTime;
//       const remainingTime = minLoadTime - elapsedTime;

//       // Đảm bảo loading hiển thị tối thiểu 1 giây
//       setTimeout(() => {
//          // Ẩn div loading
//          loadingDiv.style.display = "none";

//          // Hiển thị nội dung chính
//          contentDiv.style.display = "block";
//       }, Math.max(remainingTime, 0));
//    };
// });
//loading transition

// Hamburger menu
const hamburger = document.getElementById('hamburger');

hamburger.addEventListener('click', () => {
   hamburger.classList.toggle('active');
});
// Hamburger menu



/* Slideshow JavaScript */
let currentSlideIndex = 0;
const slideshowArea = document.getElementById('slideshow-area');
const slides = document.querySelectorAll('.mySlides');
const totalSlides = slides.length;

// Function to update slide position
function updateSlidePosition() {
    const translateValue = -(currentSlideIndex * 100); // Move by 100% for each slide
    
    // Add scaling effect to the whole container
    slideshowArea.style.transition = 'transform 1s ease-in-out, scale 1s ease-in-out'; // Adjusted animation speed
    slideshowArea.style.transform = `translateX(${translateValue}%) scale(0.9)`;

    // Reset scale after transition
    setTimeout(() => {
        slideshowArea.style.transform = `translateX(${translateValue}%) scale(1)`;
    }, 500); // Halfway through the transition
}

// Next slide function
function next() {
    if (currentSlideIndex < totalSlides - 1) {
        currentSlideIndex++;
    } else {
        currentSlideIndex = 0; // Loop back to the first slide
    }
    updateSlidePosition();
}

// Previous slide function
function prev() {
    if (currentSlideIndex > 0) {
        currentSlideIndex--;
    } else {
        currentSlideIndex = totalSlides - 1; // Loop to the last slide
    }
    updateSlidePosition();
}

// Dot navigation function
function currentSlide(index) {
    currentSlideIndex = index - 1; // Convert to zero-based index
    updateSlidePosition();
    
}
