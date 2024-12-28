<?php

require_once __DIR__ . '/class/EventData.php';
require_once __DIR__ . '/functions/verify.php';

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
    <script src="js/index.js"></script>
</body>

</html>