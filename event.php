<?php

require_once __DIR__ . '/class/EventData.php';
require_once __DIR__ . '/functions/verify.php';
require_once __DIR__ . '/functions/eventsave.php';

session_start();

$email = verifyToken(); // Kiểm tra token trong cookie
if (!$email) {
    header('Location: login.php'); // Chuyển hướng nếu token không hợp lệ
    exit();
}

// Nếu cần, lưu lại email trong session để dùng trong phiên hiện tại
$_SESSION['email'] = $email;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $event = EventData::getEvent($id);
    $totalevents = EventData::getAllEvents();
    if (!$event) {
        include 'error.html';
        exit();
    }
} else {
    header('Location: all-event.php');
    exit();
}

?>

<html>

<head>
    <?php include 'include/head.php' ?>
    <link rel="stylesheet" href="css/detailpage.css">
</head>

<body>
    <?php include 'include/nav.php' ?>
    <main>
        <div class="event-detail">
            <div class="event-detail-image">
                <img src="<?= htmlspecialchars($event->thumbnail) ?>" alt="イベントの画像">
            </div>
            <div class="event-detail-info">
                <h1><?= htmlspecialchars($event->name) ?></h1>
                <p><span>場所</span>:&nbsp;<?= htmlspecialchars($event->location) ?></p>
                <p><span>日付</span>:&nbsp;<?= htmlspecialchars($event->date) ?></p>
                <p><span>時間</span>:&nbsp;<?= htmlspecialchars($event->time) ?></p>
                <p><span>料金</span>:&nbsp;<?= htmlspecialchars($event->price) ?></p>
                <p><?= htmlspecialchars($event->description) ?></p>
                <?php
                $isSaved = isset($_SESSION['email']) ? checkIfSaved($event->id, $_SESSION['email']) : false;
                ?>

                <div class="event-detail-nav">
                    <a href="?id=<?= ($id <= 1) ? count($totalevents) : $id - 1 ?>"><button><svg fill="#000000"
                                height="18px" width="18px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 55.753 55.753"
                                xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <path
                                            d="M12.745,23.915c0.283-0.282,0.59-0.52,0.913-0.727L35.266,1.581c2.108-2.107,5.528-2.108,7.637,0.001 c2.109,2.108,2.109,5.527,0,7.637L24.294,27.828l18.705,18.706c2.109,2.108,2.109,5.526,0,7.637 c-1.055,1.056-2.438,1.582-3.818,1.582s-2.764-0.526-3.818-1.582L13.658,32.464c-0.323-0.207-0.632-0.445-0.913-0.727 c-1.078-1.078-1.598-2.498-1.572-3.911C11.147,26.413,11.667,24.994,12.745,23.915z">
                                        </path>
                                    </g>
                                </g>
                            </svg>前へ</button></a>
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
                    <a href="?id=<?= ($id >= count($totalevents)) ? 1 : $id + 1 ?>"><button>次へ<svg fill="#000000"
                                height="18px" width="18px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 55.752 55.752"
                                xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <path
                                            d="M43.006,23.916c-0.28-0.282-0.59-0.52-0.912-0.727L20.485,1.581c-2.109-2.107-5.527-2.108-7.637,0.001 c-2.109,2.108-2.109,5.527,0,7.637l18.611,18.609L12.754,46.535c-2.11,2.107-2.11,5.527,0,7.637c1.055,1.053,2.436,1.58,3.817,1.58 s2.765-0.527,3.817-1.582l21.706-21.703c0.322-0.207,0.631-0.444,0.912-0.727c1.08-1.08,1.598-2.498,1.574-3.912 C44.605,26.413,44.086,24.993,43.006,23.916z">
                                        </path>
                                    </g>
                                </g>
                            </svg></button></a>
                </div>
            </div>
    </main>
    <div id="overlay"></div>
    <footer>
        <?php include 'include/footer.php' ?>
    </footer>
    <script src="js/menu.js"></script>
    <script src="js/search.js"></script>
    <script src="js/eventSave.js"></script>
</body>

</html>