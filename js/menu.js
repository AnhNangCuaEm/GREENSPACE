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

document.addEventListener('click', (event) => {
   const menu = document.getElementById('menu');
   const hamburger = document.getElementById('hamburger');
   // Kiểm tra xem click có xảy ra bên ngoài hamburger và menu không
   if (!hamburger.contains(event.target) && !menu.contains(event.target)) {
      if (menu.classList.contains('show')) {
         toggleMenu(); // Gọi hàm tắt menu
         hamburger.classList.toggle('active');
      }
   }
});

//logout confirmation
document.addEventListener('DOMContentLoaded', function () {
   const logoutForm = document.getElementById('logoutForm');
   const confirmationPopup = document.getElementById('confirmationPopup');
   const confirmOk = document.getElementById('confirmOk');
   const confirmCancel = document.getElementById('confirmCancel');

   // Check if elements exist before adding event listeners
   if (logoutForm && confirmationPopup && confirmOk && confirmCancel) {
      // Thêm biến để theo dõi trạng thái popup
      let isPopupVisible = false;

      // Cập nhật sự kiện submit
      logoutForm.addEventListener('submit', function (event) {
         event.preventDefault(); // Prevent form submission
         confirmationPopup.style.display = 'block'; // Show confirmation popup
         isPopupVisible = true; // Đánh dấu popup là hiển thị
         document.body.style.overflow = 'hidden'; // Vô hiệu hóa cuộn
         document.getElementById('overlay').style.display = 'block'; // Hiển thị overlay
      });

      confirmOk.addEventListener('click', function () {
         logoutForm.submit(); // Submit the form if confirmed
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
      console.error('One or more elements are missing: logoutForm, confirmationPopup, confirmOk, confirmCancel');
   }
});