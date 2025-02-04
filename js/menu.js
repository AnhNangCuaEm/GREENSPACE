// Kiểm tra xem đã load lần đầu chưa
if (!sessionStorage.getItem('hasVisited')) {
   document.querySelector('nav').classList.add('initial-load');
   // Đánh dấu đã load
   sessionStorage.setItem('hasVisited', 'true');
}

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


// Update logo link based on screen width
document.addEventListener('DOMContentLoaded', function () {
   const logoLink = document.querySelector('.navL a');

   function updateLogoLink() {
      if (window.innerWidth <= 768) {
         logoLink.href = 'index.php';
      } else {
         logoLink.href = '#';
      }
   }

   // Initial check
   updateLogoLink();

   // Update on window resize
   window.addEventListener('resize', updateLogoLink);
});

// Notification handling
document.addEventListener('DOMContentLoaded', function () {
   const notificationBell = document.querySelector('.notification-bell');
   const mobileNotificationBell = document.querySelector('.mobile-notification-bell');
   const notificationsMenu = document.getElementById('notifications-menu');
   const mobileNotificationsMenu = document.getElementById('mobile-notifications-menu');
   const notificationModal = document.getElementById('notification-modal');
   const closeNotificationModal = document.getElementById('closeNotificationModal');
   const hamburger = document.getElementById('hamburger');
   const deleteButton = document.querySelector('.delete-notification');

   // Ẩn mobile notification menu khi khởi tạo
   if (mobileNotificationsMenu) {
      mobileNotificationsMenu.style.display = 'none';
   }

   // Toggle notifications menu
   function toggleNotificationsMenu(e) {
      e.stopPropagation();
      const menu = document.getElementById('menu');
      const mobileMenu = document.getElementById('mobile-menu');
      const isMobile = window.innerWidth <= 768;
      const targetMenu = isMobile ? mobileNotificationsMenu : notificationsMenu;

      // Hide other menus first
      if (menu.classList.contains('show')) {
         menu.classList.remove('show');
         setTimeout(() => { menu.style.display = 'none'; }, 300);
         hamburger.classList.remove('active');
      }
      if (mobileMenu.classList.contains('show')) {
         mobileMenu.classList.remove('show');
         setTimeout(() => { mobileMenu.style.display = 'none'; }, 300);
         hamburger.classList.remove('active');
      }

      // Toggle notifications menu
      if (targetMenu.classList.contains('show')) {
         targetMenu.classList.remove('show');
         setTimeout(() => {
            targetMenu.style.display = 'none';
         }, 300);
      } else {
         targetMenu.style.display = 'block';
         setTimeout(() => {
            targetMenu.classList.add('show');
         }, 10);
      }
   }

   if (notificationBell) {
      notificationBell.addEventListener('click', toggleNotificationsMenu);
   }
   if (mobileNotificationBell) {
      mobileNotificationBell.addEventListener('click', toggleNotificationsMenu);
   }

   // Close notifications menu when clicking outside
   document.addEventListener('click', (event) => {
      const isMobile = window.innerWidth <= 768;
      const targetMenu = isMobile ? mobileNotificationsMenu : notificationsMenu;
      const targetBell = isMobile ? mobileNotificationBell : notificationBell;

      if (!targetBell.contains(event.target) && !targetMenu.contains(event.target)) {
         if (targetMenu.classList.contains('show')) {
            targetMenu.classList.remove('show');
            setTimeout(() => {
               targetMenu.style.display = 'none';
            }, 300);
         }
      }
   });

   // Close notification modal
   if (closeNotificationModal) {
      closeNotificationModal.addEventListener('click', () => {
         notificationModal.style.display = 'none';
         document.body.style.overflow = '';
         document.getElementById('overlay').style.display = 'none';
      });
   }

   // Function to delete notification
   function deleteNotification(notificationId) {
      fetch('functions/delete_notification.php', {
         method: 'POST',
         headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
         },
         body: `notification_id=${notificationId}`
      })
         .then(response => response.json())
         .then(data => {
            if (data.success) {
               // Xóa khỏi store
               notificationStore.delete(notificationId);
               
               // Xóa khỏi UI
               const notificationElements = document.querySelectorAll(`[data-notification-id="${notificationId}"]`);
               notificationElements.forEach(el => el.remove());
               
               // Đóng modal
               notificationModal.style.display = 'none';
               document.body.style.overflow = '';
               document.getElementById('overlay').style.display = 'none';
               
               // Tải lại danh sách thông báo
               loadNotifications();
            } else {
               console.error('Failed to delete notification:', data.message);
            }
         })
         .catch(error => {
            console.error('Error deleting notification:', error);
         });
   }

   // Add event listener for delete button
   if (deleteButton) {
      deleteButton.addEventListener('click', function() {
         const notificationId = this.getAttribute('data-notification-id');
         console.log('Deleting notification:', notificationId); // Debug log
         if (notificationId) {
            deleteNotification(notificationId);
         }
      });
   }

   // Function to show notification detail
   window.showNotificationDetail = function (notificationId) {
      const notification = notificationStore.get(notificationId);
      if (!notification) return;

      // Đánh dấu thông báo đã đọc
      if (!notification.is_read) {
         fetch('functions/mark_notification_read.php', {
            method: 'POST',
            headers: {
               'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `notification_id=${notificationId}`
         })
            .then(response => response.json())
            .then(data => {
               if (data.success) {
                  // Cập nhật trạng thái trong store
                  notification.is_read = true;
                  notificationStore.set(notificationId, notification);

                  // Cập nhật UI
                  const notificationElements = document.querySelectorAll(`[data-notification-id="${notificationId}"]`);
                  notificationElements.forEach(el => el.classList.remove('unread'));

                  // Cập nhật badge
                  const unreadCount = parseInt(document.querySelector('.notification-badge').textContent) - 1;
                  const badges = document.querySelectorAll('.notification-badge');
                  badges.forEach(badge => {
                     if (unreadCount > 0) {
                        badge.style.display = 'block';
                        badge.textContent = unreadCount;
                     } else {
                        badge.style.display = 'none';
                     }
                  });
               }
            });
      }

      // Hiển thị modal với dữ liệu từ notification
      const modalTitle = notificationModal.querySelector('.notification-title');
      const modalContent = notificationModal.querySelector('.notification-content');
      const modalMeta = notificationModal.querySelector('.notification-meta');
      const deleteButton = notificationModal.querySelector('.delete-notification');

      modalTitle.textContent = notification.title;
      modalContent.textContent = notification.content;
      modalMeta.textContent = new Date(notification.created_at).toLocaleString('ja-JP');
      
      // Set notification ID cho nút xóa
      if (deleteButton) {
         deleteButton.setAttribute('data-notification-id', notificationId);
         console.log('Set notification ID:', notificationId); // Debug log
      }

      notificationModal.style.display = 'block';
      document.body.style.overflow = 'hidden';
      document.getElementById('overlay').style.display = 'block';
   };
});

// Tạo một object để lưu trữ dữ liệu thông báo
const notificationStore = new Map();

function loadNotifications() {
   fetch('functions/get_user_notifications.php')
      .then(response => response.json())
      .then(data => {
         if (data.success) {
            // Update notification badges
            const badges = document.querySelectorAll('.notification-badge');
            badges.forEach(badge => {
               if (data.unread_count > 0) {
                  badge.style.display = 'block';
                  badge.textContent = data.unread_count;
               } else {
                  badge.style.display = 'none';
               }
            });

            // Update both notification menus
            const notificationMenus = [
               document.querySelector('#notifications-menu .menu-ul'),
               document.querySelector('#mobile-notifications-menu .menu-ul')
            ];

            const content = data.data.length === 0
               ? `<li class="menu-li">
                         <div class="empty-notification">
                             通知はありません
                         </div>
                       </li>`
               : data.data.map(notification => {
                  notificationStore.set(notification.id, notification);
                  return `
                            <li class="menu-li ${notification.is_read ? '' : 'unread'}" 
                                data-notification-id="${notification.id}"
                                onclick="showNotificationDetail(${notification.id})">
                                <div class="notification-item">
                                    <div class="notification-title">${notification.title}</div>
                                    <div class="notification-preview">${notification.short_content}</div>
                                    <div class="notification-time">${notification.created_at_formatted}</div>
                                </div>
                            </li>
                        `;
               }).join('');

            notificationMenus.forEach(menu => {
               if (menu) menu.innerHTML = content;
            });
         } else {
            console.error('Failed to load notifications:', data.message);
         }
      })
      .catch(error => {
         console.error('Error loading notifications:', error);
      });
}

// Load notifications when page loads
document.addEventListener('DOMContentLoaded', function () {
   loadNotifications();

   // Reload notifications periodically (every 3 minutes)
   setInterval(loadNotifications, 180000);
});