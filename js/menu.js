// Hamburger menu
const hamburger = document.getElementById('hamburger');

hamburger.addEventListener('click', () => {
   hamburger.classList.toggle('active');
});
// Hamburger menu

//click to show menu
document.getElementById('hamburger').addEventListener('click', toggleMenu);
function toggleMenu() {
   const menu = document.getElementById('menu');
   const mobilemenu = document.getElementById('mobile-menu');
   const isMobile = window.innerWidth <= 768; // Check if the device is mobile

   if (isMobile) {
      // Toggle mobile menu
      if (mobilemenu.classList.contains('show')) {
         mobilemenu.classList.remove('show');
         setTimeout(() => {
            mobilemenu.style.display = 'none';
         }, 300);
      } else {
         mobilemenu.style.display = 'block';
         setTimeout(() => {
            mobilemenu.classList.add('show');
         }, 10);
      }
   } else {
      // Toggle normal menu
      if (menu.classList.contains('show')) {
         menu.classList.remove('show');
         setTimeout(() => {
            menu.style.display = 'none';
         }, 300);
      } else {
         menu.style.display = 'block';
         setTimeout(() => {
            menu.classList.add('show');
         }, 10);
      }
   }
}

// Close menu when clicking outside
document.addEventListener('click', (event) => {
   const menu = document.getElementById('menu');
   const mobilemenu = document.getElementById('mobile-menu');
   const hamburger = document.getElementById('hamburger');
   // Kiểm tra xem click có xảy ra bên ngoài hamburger, menu và mobile menu không
   if (!hamburger.contains(event.target) && !menu.contains(event.target) && !mobilemenu.contains(event.target)) {
      if (menu.classList.contains('show')) {
         toggleMenu(); // Gọi hàm tắt menu
         hamburger.classList.toggle('active');
      }
      if (mobilemenu.classList.contains('show')) {
         toggleMenu(); // Gọi hàm tắt mobile menu
         hamburger.classList.toggle('active');
      }
   }
});

//logout confirmation
document.addEventListener('DOMContentLoaded', function () {
   const logoutForm = document.getElementById('logoutForm');
   const mobileLogoutForm = document.getElementById('mobile-logoutForm'); // New mobile logout form
   const confirmationPopup = document.getElementById('confirmationPopup');
   const confirmOk = document.getElementById('confirmOk');
   const confirmCancel = document.getElementById('confirmCancel');

   // Check if elements exist before adding event listeners
   if (logoutForm && mobileLogoutForm && confirmationPopup && confirmOk && confirmCancel) { // Updated check
      // Thêm biến để theo dõi trạng thái popup
      let isPopupVisible = false;

      // Cập nhật sự kiện submit cho cả hai form
      const handleLogoutSubmit = function (event) {
         event.preventDefault(); // Prevent form submission
         confirmationPopup.style.display = 'block'; // Show confirmation popup
         isPopupVisible = true; // Đánh dấu popup là hiển thị
         document.body.style.overflow = 'hidden'; // Vô hiệu hóa cuộn
         document.getElementById('overlay').style.display = 'block'; // Hiển thị overlay
      };

      logoutForm.addEventListener('submit', handleLogoutSubmit);
      mobileLogoutForm.addEventListener('submit', handleLogoutSubmit); // New event listener for mobile form

      confirmOk.addEventListener('click', function () {
         if (logoutForm) logoutForm.submit(); // Submit the form if confirmed
         if (mobileLogoutForm) mobileLogoutForm.submit(); // Submit mobile form if confirmed
         isPopupVisible = false; // Đánh dấu popup là không hiển thị
         document.body.style.overflow = ''; // Khôi phục cuộn
         document.getElementById('overlay').style.display = 'none'; // Ẩn overlay
      });

      confirmCancel.addEventListener('click', function () {
         confirmationPopup.style.display = 'none'; // Hide the popup if canceled
         isPopupVisible = false; // Đánh dấu popup là không hiển thị
         document.body.style.overflow = ''; // Khôi phục cuộn
         document.getElementById('overlay').style.display = 'none'; // Ẩn overlay
      });

      // Chặn click bên ngoài nếu popup đang hiển thị
      document.addEventListener('click', (event) => {
         if (isPopupVisible) {
            event.stopPropagation(); // Ngăn chặn sự kiện click
         }
      });
   } else {
      console.error('One or more elements are missing: logoutForm, mobileLogoutForm, confirmationPopup, confirmOk, confirmCancel'); // Updated error message
   }
});