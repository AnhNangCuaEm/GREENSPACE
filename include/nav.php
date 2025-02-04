<?php

require_once __DIR__ . '/../class/UserData.php';

$user = UserData::getProfile();

?>
<div class="navigation-div">
    <nav>
        <div class="navL">
            <a href="#"><img class="navLogo" src="img/img/logo.png" alt=""></a>
            <ul>
                <li><a href="index.php">ホーム</a></li>
                <li><a href="all.php">探る</a></li>
                <li><a href="all-event.php">イベント</a></li>
            </ul>
        </div>
        <div id="search" class="searchBtn">
            <div>
                <input type="text" class="glow-on-focus" id="searchInput" placeholder="検索">
                <svg class="search-icon" width="20px" height="20px" viewBox="0 -0.5 25 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg" transform="matrix(-1, 0, 0, 1, 0, 0)">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.30524 15.7137C6.4404 14.8306 5.85381 13.7131 5.61824 12.4997C5.38072 11.2829 5.50269 10.0233 5.96924 8.87469C6.43181 7.73253 7.22153 6.75251 8.23924 6.05769C10.3041 4.64744 13.0224 4.64744 15.0872 6.05769C16.105 6.75251 16.8947 7.73253 17.3572 8.87469C17.8238 10.0233 17.9458 11.2829 17.7082 12.4997C17.4727 13.7131 16.8861 14.8306 16.0212 15.7137C14.8759 16.889 13.3044 17.5519 11.6632 17.5519C10.0221 17.5519 8.45059 16.889 7.30524 15.7137V15.7137Z"
                        stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M15.5824 16.1485L18.9704 19.5305L20.0301 18.4689L16.6421 15.0869L15.5824 16.1485Z"
                        fill="#000000"></path>
                </svg>
            </div>
        </div>
        <div class="navR">
            <ul>
                <li>
                    <div class="notification-bell">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge" style="display: none;">0</span>
                    </div>
                </li>
                <li><a href="profile.php"><img src="<?php echo htmlspecialchars($user->avatar); ?>"
                            alt="User Avatar"></a></li>
                <div class="hamburger" id="hamburger">
                    <div class="menuLine"></div>
                </div>
            </ul>
        </div>
    </nav>
    <div class="notifications-menu" id="notifications-menu">
        <ul class="menu-ul">
            <!-- Notifications will be loaded here -->
        </ul>
    </div>
    <div class="menu" id="menu">
        <ul class="menu-ul">
            <li><a href="contact.php">問い合せ</a></li>
            <li><a href="privacy.php">Privacy</a></li>
            <li><a href="credit.php">Credit</a></li>
            <form id="logoutForm" action="logout.php" method="post">
                <button id="logoutButton" type="submit">サインアウト</button>
            </form>
        </ul>
    </div>
    <div class="mobile-menu" id="mobile-menu">
        <ul class="mobile-menu-ul">
            <li>
                <div class="mobile-menu-icon">
                    <a href="profile.php"><img src="<?php echo htmlspecialchars($user->avatar); ?>"
                            alt="User Avatar"></a>
                </div>
            </li>
            <li>
                <div class="mobile-notification-bell">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge" style="display: none;">0</span>
                </div>
            </li>
            <li><a href="all.php">探る</a></li>
            <li><a href="all-event.php">イベント</a></li>
            <li><a href="contact.php">問い合せ</a></li>
            <li><a href="privacy.php">Privacy</a></li>
            <li><a href="credit.php">Credit</a></li>
            <form id="mobile-logoutForm" action="logout.php" method="post">
                <button id="mobile-logoutButton" type="submit">サインアウト</button>
            </form>
        </ul>
    </div>
    <div class="mobile-notifications-menu" id="mobile-notifications-menu">
        <ul class="menu-ul">
            <!-- Mobile notifications will be loaded here -->
        </ul>
    </div>
    <div id="searchResults" class="search-results">
        <div class="glow-background"></div>
        <div class="results-content"></div>
    </div>
</div>

<div id="confirmationPopup" class="confirmation-popup" style="display: none">
    <div class="confirmation-popup-content">
        <p>ログアウトしますか？</p>
        <div>
            <button id="confirmCancel" style="background-color: rgb(71, 181, 245);">戻る</button>
            <button id="confirmOk">確定</button>
        </div>
    </div>
</div>

<div id="notification-modal" class="confirmation-popup" style="display: none">
    <div class="confirmation-popup-content">
        <h3 class="notification-title"></h3>
        <p class="notification-content"></p>
        <div class="notification-meta"></div>
        <div class="notification-actions">
            <button id="closeNotificationModal">閉じる</button>
            <button class="delete-notification">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</div>