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
    if (!$event) {
        // Hiển thị giao diện lỗi
?>
        <html>

        <head>
            <title>404 Not Found</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
                rel="stylesheet">
            <style>
                body {
                    font-family: Montserrat, sans-serif;
                    background-color: #f0f0f0;
                    color: #333;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }

                a {
                    text-decoration: none;
                    color: #fcf8db;
                }

                h1 {
                    font-size: 1.6rem;
                    margin: 0;
                    padding: 0;
                }

                p {
                    font-size: 1.2rem;
                    font-weight: bold;
                    margin: 0;
                    padding: 0;
                }

                button {
                    position: relative;
                    left: 50%;
                    transform: translateX(-50%);
                    padding: 10px 20px;
                    background-color: rgb(145, 145, 145);
                    border: none;
                    border-radius: 10px;
                    margin: 20px auto 0 auto;
                }
            </style>
        </head>

        <body>
            <svg width="200px" height="200px" viewBox="0 0 1024 1024" fill="#000000" class="icon" version="1.1"
                xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M161.6 923.2c-15.2 0-30.4-6.4-40.8-17.6-22.4-22.4-22.4-60 0-82.4 11.2-11.2 25.6-17.6 40.8-17.6 15.2 0 30.4 6.4 40.8 17.6 22.4 22.4 22.4 60 0 82.4-10.4 12-24.8 17.6-40.8 17.6z m0-68c-2.4 0-4.8 0.8-6.4 2.4-4 4-4 10.4 0 14.4 1.6 1.6 4 2.4 6.4 2.4 2.4 0 4.8-0.8 6.4-2.4 4-4 4-10.4 0-14.4-1.6-1.6-4-2.4-6.4-2.4z"
                        fill=""></path>
                    <path
                        d="M178.4 972c-24.8 0-47.2-9.6-64.8-27.2l-24-24c-35.2-36-35.2-94.4 0-130.4l1.6-1.6 423.2-362.4c-25.6-43.2-37.6-93.6-33.6-144 4-59.2 28.8-114.4 69.6-156 45.6-46.4 106.4-72 171.2-72 31.2 0 62.4 6.4 91.2 18.4 7.2 3.2 12.8 9.6 14.4 17.6 1.6 8-0.8 16-6.4 21.6L696.8 236.8l84 85.6L904 198.4c4.8-4.8 11.2-7.2 17.6-7.2 1.6 0 3.2 0 4.8 0.8 8 1.6 14.4 7.2 17.6 14.4 18.4 44 23.2 92.8 14.4 140-8.8 48.8-32 92.8-66.4 128-45.6 46.4-105.6 72-169.6 72-35.2 0-70.4-8-101.6-23.2l-377.6 421.6c-17.6 17.6-40.8 27.2-64.8 27.2z m-54.4-147.2c-16 17.6-16 44.8 0.8 61.6l24 24c8 8 18.4 12.8 29.6 12.8 11.2 0 21.6-4.8 29.6-12.8l388.8-434.4c4.8-4.8 11.2-8 18.4-8 4 0 8.8 0.8 12 3.2 28.8 16.8 61.6 25.6 95.2 25.6 51.2 0 98.4-20 134.4-56.8 45.6-47.2 65.6-113.6 52.8-178.4l-112 112.8c-4.8 4.8-11.2 7.2-17.6 7.2-6.4 0-12.8-2.4-17.6-7.2L645.6 253.6c-9.6-9.6-9.6-24.8 0-34.4l112-112.8c-12-2.4-24-3.2-36-3.2-51.2 0-100 20.8-136 57.6-68 68.8-75.2 176.8-18.4 256 7.2 10.4 5.6 24.8-4 32.8l-439.2 375.2z"
                        fill=""></path>
                    <path
                        d="M405.6 522.4c-6.4 0-12.8-2.4-17.6-7.2L216 340h-58.4c-8.8 0-16.8-4.8-20.8-12L57.6 198.4c-5.6-9.6-4-22.4 4-30.4l64-64.8c4.8-4.8 11.2-7.2 17.6-7.2 4.8 0 8.8 1.6 12.8 4l130.4 81.6c7.2 4.8 11.2 12 11.2 20l0.8 58.4 176.8 181.6c4.8 4.8 7.2 11.2 7.2 17.6 0 6.4-2.4 12.8-7.2 16.8-4.8 4.8-10.4 7.2-16.8 7.2s-12.8-2.4-17.6-7.2L256 287.2c-4-4.8-7.2-10.4-7.2-16.8l-0.8-55.2-102.4-64-36.8 37.6 62.4 102.4h54.4c6.4 0 12.8 2.4 17.6 7.2l179.2 182.4c4.8 4.8 7.2 11.2 7.2 17.6 0 6.4-2.4 12.8-7.2 17.6-4 4-10.4 6.4-16.8 6.4zM768.8 979.2c-15.2 0-30.4-6.4-40.8-17.6L520.8 748c-22.4-22.4-22.4-59.2 0-82.4l6.4-6.4-7.2-7.2c-9.6-9.6-9.6-24.8 0.8-34.4 4.8-4.8 10.4-7.2 16.8-7.2s12.8 2.4 17.6 7.2l24 24c9.6 9.6 8.8 24.8 0 34.4l-23.2 24c-4 4-4 10.4 0 14.4L763.2 928c1.6 1.6 4 2.4 6.4 2.4 2.4 0 4.8-0.8 6.4-2.4l94.4-96.8c4-4 4-10.4 0-14.4l-208-213.6c-1.6-1.6-4-2.4-6.4-2.4-2.4 0-4.8 0.8-6.4 2.4L624 629.6c-4.8 4.8-11.2 7.2-17.6 7.2-6.4 0-12.8-2.4-17.6-7.2L568 606.4c-4.8-4.8-7.2-11.2-7.2-17.6 0-6.4 2.4-12.8 7.2-16.8 4.8-4.8 10.4-7.2 16.8-7.2s12.8 2.4 17.6 7.2l4.8 4.8 8-8c11.2-11.2 25.6-17.6 40.8-17.6 15.2 0 30.4 6.4 40.8 17.6L904 782.4c22.4 22.4 22.4 60 0 82.4l-94.4 96.8c-10.4 11.2-24.8 17.6-40.8 17.6z"
                        fill=""></path>
                </g>
            </svg>
            <div>
                <h1>アクセスされたURLは存在しません!</h1>
                <p id="countdown">10秒後、ホームページへ自動的に移動されます!</p>
                <button><a href="index.php">ホームページに戻る</a></button>
            </div>
            <script>
                let timeLeft = 10; // Set the countdown time in seconds
                const countdownElement = document.getElementById('countdown');

                const countdownInterval = setInterval(() => {
                    timeLeft--;
                    countdownElement.textContent = `${timeLeft}秒後、ホームページへ自動的に移動されます!`;

                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);
                        window.location.href = 'index.php'; // Redirect to index.php
                    }
                }, 1000); // Update every second
            </script>
        </body>

        </html>
<?php
        exit();
    }
} else {
    header('Location: all-event.php');
    exit();
}

// Fetch all event IDs from the database
$eventIds = EventData::getAllEventIds(); // Assume this function returns an array of event IDs

// Find the current event's position in the list
$currentIndex = array_search($id, $eventIds);

// Determine the previous and next event IDs
$prevId = ($currentIndex > 0) ? $eventIds[$currentIndex - 1] : end($eventIds);
$nextId = ($currentIndex < count($eventIds) - 1) ? $eventIds[$currentIndex + 1] : $eventIds[0];

?>

<html>

<head>
    <?php include 'include/head.php' ?>
    <link rel="stylesheet" href="css/detailpage.css">
</head>

<body>
    <?php include 'include/nav.php' ?>
    <main style="max-width: 850px;">
        <div class="event-detail">
            <div class="event-detail-image">
                <div class="image-container loading">
                    <div>
                        <img src="<?= htmlspecialchars($event->thumbnail) ?>" alt="イベントの画像" onload="this.classList.add('loaded'); this.parentElement.parentElement.classList.remove('loading')">
                    </div>
                </div>
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
                    <a href="?id=<?= $prevId ?>"><button><svg fill="#000000"
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
                    <a href="?id=<?= $nextId ?>"><button>次へ<svg fill="#000000"
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