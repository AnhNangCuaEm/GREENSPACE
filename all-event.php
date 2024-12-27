<?php

require_once __DIR__ . '/class/EventData.php';

session_start();

$events = EventData::getAllEvents();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

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
        <footer>
            <?php include 'include/footer.php' ?>
        </footer>
    </div>
    <script src="js/menu.js"></script>
    <script src="js/index.js"></script>
</body>

</html>