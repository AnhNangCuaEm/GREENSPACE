<?php

require_once __DIR__ . '/class/EventData.php';
require_once __DIR__ . '/functions/verify.php';
require_once __DIR__ . '/functions/eventsave.php';

session_start();

$events = EventData::getAllEvents();

$email = verifyToken(); // Kiểm tra token trong cookie
if (!$email) {
    header('Location: login.php'); // Chuyển hướng nếu token không hợp lệ
    exit();
}

// Nếu cần, lưu lại email trong session để dùng trong phiên hiện tại
$_SESSION['email'] = $email;

?>

<html>

<head>
    <?php include 'include/head.php' ?>
</head>

<body>
    <div id="content">
        <?php include 'include/nav.php' ?>
        <main>
            <h1>イベント一覧</h1>
            <div class="event-container">
                <?php foreach ($events as $event): ?>
                    <div class="event-box">
                        <a href="event.php?id=<?= $event->id ?>"><img src="<?= $event->thumbnail ?>"></a>
                        <div class="event-text">
                            <div class="name"><?= $event->name ?></div>
                            <div class="location"><span>場所:</span>&nbsp;<?= $event->location ?></div>
                            <div class="date"><span>日付:</span>&nbsp;<?= $event->date ?></div>
                            <div class="time"><span>時間:</span>&nbsp;<?= $event->time ?></div>
                            <div class="price"><span>料金:</span>&nbsp;<?= $event->price ?></div>
                            <div class="description"><span>内容:</span>&nbsp;<?= $event->description ?></div>
                        </div>
                        <?php
                        $isSaved = isset($_SESSION['email']) ? checkIfSaved($event->id, $_SESSION['email']) : false;
                        ?>
                        <button class="save-button" data-event-id="<?= $event->id ?>">
                            <svg class="save-icon" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16 8.98987V20.3499C16 21.7999 14.96 22.4099 13.69 21.7099L9.76001 19.5199C9.34001 19.2899 8.65999 19.2899 8.23999 19.5199L4.31 21.7099C3.04 22.4099 2 21.7999 2 20.3499V8.98987C2 7.27987 3.39999 5.87988 5.10999 5.87988H12.89C14.6 5.87988 16 7.27987 16 8.98987Z"
                                        stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <path opacity="0.4"
                                        d="M22 5.10999V16.47C22 17.92 20.96 18.53 19.69 17.83L16 15.77V8.98999C16 7.27999 14.6 5.88 12.89 5.88H8V5.10999C8 3.39999 9.39999 2 11.11 2H18.89C20.6 2 22 3.39999 22 5.10999Z"
                                        stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                    <g opacity="0.4">
                                        <path d="M7 12H11" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                        <path d="M9 14V10" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </svg>
                            <span class="save-text"><?= $isSaved ? '保存を削除' : '保存する' ?></span>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
        <div id="overlay"></div>
        <footer>
            <?php include 'include/footer.php' ?>
        </footer>
    </div>
    <script src="js/menu.js"></script>
    <script src="js/eventSave.js"></script>
</body>

</html>