// Check if the initial load has occurred
if (!sessionStorage.getItem('hasVisited')) {
   document.querySelector('nav').classList.add('initial-load');
   // Mark as loaded
   sessionStorage.setItem('hasVisited', 'true');
}

// Hamburger menu
const hamburger = document.getElementById('hamburger');

hamburger.addEventListener('click', () => {
   hamburger.classList.toggle('active');
});

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
   // Check if the click occurred outside the hamburger, menu, and mobile menu
   if (!hamburger.contains(event.target) && !menu.contains(event.target) && !mobilemenu.contains(event.target)) {
      if (menu.classList.contains('show')) {
         toggleMenu(); // Call the menu toggle function
         hamburger.classList.toggle('active');
      }
      if (mobilemenu.classList.contains('show')) {
         toggleMenu(); // Call the menu toggle function
         hamburger.classList.toggle('active');
      }
   }
});

//logout confirmation
document.addEventListener('DOMContentLoaded', function () {
   const logoutForm = document.getElementById('logoutForm');
   const mobileLogoutForm = document.getElementById('mobile-logoutForm');
   const confirmationPopup = document.getElementById('confirmationPopup');
   const confirmOk = document.getElementById('confirmOk');
   const confirmCancel = document.getElementById('confirmCancel');

   // Check if elements exist before adding event listeners
   if (logoutForm && mobileLogoutForm && confirmationPopup && confirmOk && confirmCancel) {
      // Add variable to track popup status
      let isPopupVisible = false;

      // Update submit event for both forms
      const handleLogoutSubmit = function (event) {
         event.preventDefault();
         confirmationPopup.style.display = 'block'; // Show confirmation popup
         isPopupVisible = true; // Mark popup as visible
         document.body.style.overflow = 'hidden';
         document.getElementById('overlay').style.display = 'block'; // Show overlay
      };

      logoutForm.addEventListener('submit', handleLogoutSubmit);
      mobileLogoutForm.addEventListener('submit', handleLogoutSubmit); // New event listener for mobile form

      confirmOk.addEventListener('click', function () {
         if (logoutForm) logoutForm.submit();
         if (mobileLogoutForm) mobileLogoutForm.submit();
         isPopupVisible = false;
         document.body.style.overflow = '';
         document.getElementById('overlay').style.display = 'none';
      });

      confirmCancel.addEventListener('click', function () {
         confirmationPopup.style.display = 'none'; // Hide the popup if canceled
         isPopupVisible = false;
         document.body.style.overflow = '';
         document.getElementById('overlay').style.display = 'none';
      });

      // Prevent click outside if popup is visible
      document.addEventListener('click', (event) => {
         if (isPopupVisible) {
            event.stopPropagation();
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

   // Hide mobile notification menu when initialized
   if (mobileNotificationsMenu) {
      mobileNotificationsMenu.style.display = 'none';
   }

   // Toggle notifications menu
   function toggleNotificationsMenu(e) {
      e.stopPropagation();
      const menu = document.getElementById('menu');
      const mobileMenu = document.getElementById('mobile-menu');
      const searchResults = document.getElementById('searchResults');
      const isMobile = window.innerWidth <= 768;
      const targetMenu = isMobile ? mobileNotificationsMenu : notificationsMenu;

      // Hide search results
      if (searchResults) {
         searchResults.classList.remove('show');
         setTimeout(() => {
            searchResults.style.display = 'none';
         }, 300);
      }

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
               // Remove from store
               notificationStore.delete(notificationId);

               // Remove from UI
               const notificationElements = document.querySelectorAll(`[data-notification-id="${notificationId}"]`);
               notificationElements.forEach(el => el.remove());

               // Close modal
               notificationModal.style.display = 'none';
               document.body.style.overflow = '';
               document.getElementById('overlay').style.display = 'none';

               // Reload notifications
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
      deleteButton.addEventListener('click', function () {
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

      // Mark notification as read
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
                  // Update status in store
                  notification.is_read = true;
                  notificationStore.set(notificationId, notification);

                  // Update UI
                  const notificationElements = document.querySelectorAll(`[data-notification-id="${notificationId}"]`);
                  notificationElements.forEach(el => el.classList.remove('unread'));

                  // Update badge
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

      // Show modal with data from notification
      const modalTitle = notificationModal.querySelector('.notification-title');
      const modalContent = notificationModal.querySelector('.notification-content');
      const modalMeta = notificationModal.querySelector('.notification-meta');
      const deleteButton = notificationModal.querySelector('.delete-notification');

      modalTitle.textContent = notification.title;
      modalContent.textContent = notification.content;
      modalMeta.textContent = new Date(notification.created_at).toLocaleString('ja-JP');

      // Set notification ID for delete button
      if (deleteButton) {
         deleteButton.setAttribute('data-notification-id', notificationId);
         console.log('Set notification ID:', notificationId); // Debug log
      }

      notificationModal.style.display = 'block';
      document.body.style.overflow = 'hidden';
      document.getElementById('overlay').style.display = 'block';
   };
});

// Create an object to store notification data
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
                  // Truncate content if it's too long
                  const shortContent = notification.short_content.length > 70 
                     ? notification.short_content.substring(0, 70) + '...'
                     : notification.short_content;
                  
                  return `
                        <li class="menu-li ${notification.is_read ? '' : 'unread'}" 
                            data-notification-id="${notification.id}"
                            onclick="showNotificationDetail(${notification.id})">
                            <div class="notification-item">
                                <div class="notification-title">${notification.title}</div>
                                <div class="notification-preview">${shortContent}</div>
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
         console.error('Error details:', error.message);
      });
}

// Load notifications when page loads
document.addEventListener('DOMContentLoaded', function () {
   loadNotifications();

   // Reload notifications periodically (every 3 minutes)
   setInterval(loadNotifications, 180000);
});