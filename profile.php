<?php

require_once __DIR__ . '/class/UserData.php';
require_once __DIR__ . '/class/ParkData.php';
require_once __DIR__ . '/class/EventData.php';
require_once __DIR__ . '/functions/verify.php';
require_once __DIR__ . '/functions/parklike.php';
require_once __DIR__ . '/functions/eventsave.php';

session_start();


$email = verifyToken(); // Kiểm tra token trong cookie
if (!$email) {
    header('Location: login.php'); // Chuyển hướng nếu token không hợp lệ
    exit();
}

// Nếu cần, lưu lại email trong session để dùng trong phiên hiện tại
$_SESSION['email'] = $email;

$email = $_SESSION['email'];
$user = UserData::getProfile();

?>

<html>

<head>
    <?php include 'include/head.php' ?>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <?php include 'include/nav.php' ?>
    <main>
        <div class="profile-container">
            <div class="avatar-box">
                <img src="<?php echo htmlspecialchars($user->avatar); ?>" alt="User Avatar">
                <button id="changeAvtBtn" class="changeAvtBtn">変更</button>
            </div>
            <div class="user-box">
                <div class="user-info">
                    <p>お名前:&nbsp;<span><?php echo htmlspecialchars($user->name); ?></span></p>
                    <p>メールアドレス:&nbsp;<span><?php echo htmlspecialchars($user->email); ?></span></p>
                    <p>電話番号:&nbsp;<span><?php echo ($user->phone != 0) ? htmlspecialchars($user->phone) : ''; ?></span>
                    </p>
                    <p>住所:&nbsp;<span><?php echo htmlspecialchars($user->address); ?></span></p>
                </div>
                <button id="editBtn" class="editBtn">編集<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path
                                d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </g>
                    </svg></button>
            </div>
        </div>
        <div class="park-event-container">
            <div class="liked-park-box">
                <h2>お気に入りの公園</h2>
                <?php
                $likedParkIds = getLikedParks($email);
                if (!empty($likedParkIds)) {
                    echo '<div class="liked-parks-box">';
                    foreach ($likedParkIds as $parkId) {
                        $park = ParkData::getPark($parkId);
                        if ($park) {
                            echo '<div class="park-card">';
                            echo '<img src="' . htmlspecialchars($park->thumbnail) . '" alt="' . htmlspecialchars($park->name) . '">';
                            echo '<h3>' . htmlspecialchars($park->name) . '</h3>';
                            echo '<p>' . htmlspecialchars($park->location) . '</p>';
                            echo '<a href="park.php?id=' . htmlspecialchars($parkId) . '" class="view-park-btn">詳細を見る</a>';
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                } else {
                    echo '<p class="no-parks-message">お気に入りの公園がありません。</p>';
                }
                ?>
            </div>
            <div class="saved-event-box">
                <h2>保存したイベント</h2>
                <?php
                $savedEventIds = getSavedEvents($email);
                if (!empty($savedEventIds)) {
                    echo '<div class="saved-events-box">';
                    foreach ($savedEventIds as $eventId) {
                        $event = EventData::getEvent($eventId);
                        if ($event) {
                            echo '<div class="event-card">';
                            echo '<img src="' . htmlspecialchars($event->thumbnail) . '" alt="' . htmlspecialchars($event->name) . '">';
                            echo '<h3>' . htmlspecialchars($event->name) . '</h3>';
                            echo '<a href="event.php?id=' . htmlspecialchars($eventId) . '" class="view-event-btn">詳細を見る</a>';
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                } else {
                    echo '<p class="no-events-message">保存したイベントがありません。</p>';
                }
                ?>
            </div>
        </div>
        <div class="avatar-popup" id="avatarPopup">
            <div class="popup-content">
                <h2>アバターを選択</h2>
                <div class="avatar-options">
                    <img src="https://pw11a12425.blob.core.windows.net/avatar/bear.png" alt="Bear"
                        class="avatar-option">
                    <img src="https://pw11a12425.blob.core.windows.net/avatar/cat.png" alt="Cat" class="avatar-option">
                    <img src="https://pw11a12425.blob.core.windows.net/avatar/dear.png" alt="Dear"
                        class="avatar-option">
                    <img src="https://pw11a12425.blob.core.windows.net/avatar/dog.png" alt="Dog" class="avatar-option">
                    <img src="https://pw11a12425.blob.core.windows.net/avatar/fox.png" alt="Fox" class="avatar-option">
                    <img src="https://pw11a12425.blob.core.windows.net/avatar/lion.png" alt="Lion"
                        class="avatar-option">
                    <img src="https://pw11a12425.blob.core.windows.net/avatar/panda.png" alt="Panda"
                        class="avatar-option">
                    <img src="https://pw11a12425.blob.core.windows.net/avatar/pig.png" alt="Pig" class="avatar-option">
                    <img src="https://pw11a12425.blob.core.windows.net/avatar/rabbit.png" alt="Rabbit"
                        class="avatar-option">
                    <img src="https://pw11a12425.blob.core.windows.net/avatar/wolf.png" alt="Wolf"
                        class="avatar-option">
                </div>
                <div class="avtBtn">
                    <button id="applyAvatar">確定</button>
                    <button id="closePopup" class="cancelBtn">戻る</button>
                </div>
            </div>
        </div>
        <div class="info-popup" id="infoPopup">
            <div class="info-popup-content">
                <h3>プロフィールを編集</h3>
                <form id="editForm">
                    <div>
                        <label for="name">お名前:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user->name); ?>">
                    </div>
                    <div>
                        <label for="phone">電話番号:</label>
                        <input type="text" id="phone" name="phone"
                            value="<?php echo ($user->phone != 0) ? htmlspecialchars($user->phone) : ''; ?>">
                    </div>
                    <div>
                        <label for="address">住所:</label>
                        <input type="text" id="address" name="address"
                            value="<?php echo htmlspecialchars($user->address); ?>">
                    </div>
                    <div class="infoBtn">
                        <button type="submit">確定</button>
                        <button type="button" id="closeInfoPopup" class="cancelBtn">戻る</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="result-popup" id="result"></div>
    </main>
    <div id="overlay"></div>
    <footer>
        <?php include 'include/footer.php' ?>
    </footer>
    <script src="js/menu.js"></script>
    <script src="js/editProfile.js"></script>
    <script src="js/profile.js"></script>
</body>

</html>