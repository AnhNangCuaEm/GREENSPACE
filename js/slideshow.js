//Slide move X and scale like ios widget
let currentSlideIndex = 0;
let autoNextInterval;
const slideshowArea = document.getElementById('slideshow-area');
const slides = document.querySelectorAll('.mySlides');
const totalSlides = slides.length;

// Function to update slide position
function updateSlidePosition() {
   const translateValue = -(currentSlideIndex * 100); // Move by 100% for each slide

   // Add scaling effect only to the current slide
   slides.forEach((slide, index) => {
      slide.style.transition = 'transform 1s ease-in-out'; // Adjusted animation speed
      slide.style.transform = index === currentSlideIndex ? 'scale(1)' : 'scale(0.8)'; // Scale current slide
   });

   // Apply translateX animation to the slideshow area
   slideshowArea.style.transition = 'transform 1s ease-in-out'; // Ensure transition for the slideshow area
   slideshowArea.style.transform = `translateX(${translateValue}%)`; // Only translate the slideshow area
}

// Next slide function
function next() {
   clearInterval(autoNextInterval); // Clear auto next interval
   if (currentSlideIndex < totalSlides - 1) {
      currentSlideIndex++;
   } else {
      currentSlideIndex = 0; // Loop back to the first slide
   }
   updateSlidePosition();
   updateDotNavigation();
   startAutoNext(); // Restart auto next interval
}

// Previous slide function
function prev() {
   clearInterval(autoNextInterval); // Clear auto next interval
   if (currentSlideIndex > 0) {
      currentSlideIndex--;
   } else {
      currentSlideIndex = totalSlides - 1; // Loop to the last slide
   }
   updateSlidePosition();
   updateDotNavigation();
}

// Dot navigation function
function currentSlide(index) {
   currentSlideIndex = index - 1; // Convert to zero-based index
   updateSlidePosition();
   updateDotNavigation();
}

// Function to update dot navigation
function updateDotNavigation() {
   const dots = document.querySelectorAll('.dot'); // Get all dots
   dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === currentSlideIndex); // Add active class to current dot
   });
}

function startAutoNext() {
   autoNextInterval = setInterval(next, 10000); // Auto next slide every 10 seconds
}

function stopAutoNext() {
   clearInterval(autoNextInterval); // Stop auto next slide
}

window.onload = () => {
   setTimeout(() => {
      updateSlidePosition(); // Call function after page is ready
      updateDotNavigation(); // Update dot navigation
      startAutoNext(); // Start auto next slide
   }, 100); // Delay of 100ms to ensure DOM is loaded
};
