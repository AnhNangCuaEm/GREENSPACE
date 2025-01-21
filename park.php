<?php

require_once __DIR__ . '/class/UserData.php';
require_once __DIR__ . '/class/ParkData.php';
require_once __DIR__ . '/class/ParkImageData.php';
require_once __DIR__ . '/functions/verify.php';
require_once __DIR__ . '/functions/parklike.php';
require_once __DIR__ . '/functions/comment.php';
require_once __DIR__ . '/functions/track_visits.php';

session_start();

$email = verifyToken(); // Kiểm tra token trong cookie
if (!$email) {
    header('Location: login.php'); // Chuyển hướng nếu token không hợp lệ
    exit();
}

// Nếu cần, lưu lại email trong session để dùng trong phiên hiện tại
$_SESSION['email'] = $email;

if (isset($_GET['id'])) {
    $parkId = $_GET['id'];
    trackPageVisit("park.php?id={$parkId}");
} else {
    trackPageVisit('park.php');
}

$isLiked = false; // Khởi tạo biến $isLiked
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $parks = ParkData::getPark($id);

    // Kiểm tra xem công viên có tồn tại không
    if (!$parks) {
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

    $images = ParkImageData::getParkImages($id);
    $likeCount = countLikes($id);

    $parkIds = ParkData::getAllParkIds(); // Assume this function returns an array of event IDs

    // Find the current event's position in the list
    $currentIndex = array_search($id, $parkIds);

    // Determine the previous and next event IDs
    $prevId = ($currentIndex > 0) ? $parkIds[$currentIndex - 1] : end($parkIds);
    $nextId = ($currentIndex < count($parkIds) - 1) ? $parkIds[$currentIndex + 1] : $parkIds[0];

    // Kiểm tra trạng thái like
    $isLiked = checkIfLiked($id, $_SESSION['email']);
} else {
    header('Location: index.php');
    exit();
}

?>
<html>

<head>
    <?php include 'include/head.php' ?>
    <link rel="stylesheet" href="css/detailpage.css">
</head>

<body>
    <div class="gradient-bg">
        <svg xmlns="http://www.w3.org/2000/svg">
            <defs>
                <filter id="goo">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -8"
                        result="goo" />
                    <feBlend in="SourceGraphic" in2="goo" />
                </filter>
            </defs>
        </svg>
        <div class="gradients-container">
            <div class="g1"></div>
            <div class="g2"></div>
            <div class="interactive"></div>
        </div>
    </div>
    <div class="content-wrapper">
        <?php include 'include/nav.php' ?>
        <main>
            <div class="park-detail">
                <div class="park-detail-image">
                    <div class="image-container loading">
                        <div>
                            <img src="<?= htmlspecialchars($parks->thumbnail) ?>" alt="公園の画像"
                                onload="this.classList.add('loaded'); this.parentElement.parentElement.classList.remove('loading')">
                        </div>
                    </div>
                </div>
                <div class="park-detail-info">
                    <h1><?= htmlspecialchars($parks->name) ?></h1>
                    <p><span>住所:</span>&nbsp;<?= htmlspecialchars($parks->location) ?></p>
                    <p><span>面積:</span>&nbsp;<?= htmlspecialchars($parks->area) ?>&nbsp;&#x33A1;</p>
                    <p><span>料金:</span>&nbsp;<?= htmlspecialchars($parks->price) ?></p>
                    <p><span>最寄り駅:</span>&nbsp;<?= $parks->nearest ?></p>
                    <p><span>特徴:</span>&nbsp;<?= $parks->special ?></p>
                    <p><?= htmlspecialchars($parks->description) ?></p>
                    <div class="park-detail-nav">
                        <a href="?id=<?= $prevId ?>"><button><svg fill="#000000" height="24px" width="24px"
                                    version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
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
                        <a href="?id=<?= $nextId ?>"><button>次へ<svg fill="#000000" height="24px" width="24px"
                                    version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
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
                        <div class="park-like-box">
                            <div id="likeCount"><?= htmlspecialchars($likeCount) ?></div>
                            <svg id="likeSvg" width="34px" height="34px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" style="fill: <?= $isLiked ? '#fcf8db' : 'none' ?>;">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z"
                                        stroke="#fcf8db" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                    </path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="park-comment-box">
                        <h2>コメント :</h2>
                        <?php
                        $comments = getCommentsByParkId($id);
                        if (!empty($comments)): ?>
                            <div class="comments-list">
                                <?php foreach ($comments as $comment): ?>
                                    <div class="comment-item">
                                        <div class="comment-header">
                                            <strong><?= htmlspecialchars($comment['user_name'] ?: '無名さん') ?></strong>
                                            <?php if (isOwner($comment['id'], $_SESSION['email'] ?? '')): ?>
                                                <svg class="delete-comment" data-comment-id="<?= $comment['id'] ?>" width="24px"
                                                    height="24px" viewBox="0 0 24 24" ...>
                                                    <!-- existing SVG code -->
                                                </svg>
                                            <?php endif; ?>
                                            <span
                                                class="comment-date"><?= date('Y-m-d H:i', strtotime($comment['created_at'])) ?></span>
                                        </div>
                                        <div class="comment-content">
                                            <?= htmlspecialchars($comment['content']) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>まだコメントがありません。</p>
                        <?php endif; ?>
                        <button id="openCommentPopup" class="comment-button">コメントする</button>
                    </div>
                </div>
                <div class="park-map">
                    <?= $parks->map ?>
                </div>
                <div class="park-images-list" id="imageSlider">
                    <?php foreach ($images as $image): ?>
                        <div class="park-images-box" onclick="openModal('<?= htmlspecialchars($image['image_url']) ?>')">
                            <div class="image-container loading">
                                <div>
                                    <img src="<?= htmlspecialchars($image['image_url']) ?>" alt="公園の画像"
                                        onload="this.classList.add('loaded'); this.parentElement.parentElement.classList.remove('loading')">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="result-popup" id="result"></div>
        </main>
        <div class="comment-popup">
            <div class="comment-popup-content">
                <?php
                $comments = getAllCommentsByParkId($id);
                if (!empty($comments)): ?>
                    <div class="comments-list">
                        <?php foreach ($comments as $comment): ?>
                            <div class="comment-item">
                                <div class="comment-header">
                                    <strong><?= htmlspecialchars($comment['user_name'] ?: '無名さん') ?></strong>
                                    <?php if (isOwner($comment['id'], $_SESSION['email'] ?? '')): ?>
                                        <svg class="delete-comment" data-comment-id="<?= $comment['id'] ?>" width="24px"
                                            height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <title>delete_2_line</title>
                                                <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g id="System" transform="translate(-576.000000, -192.000000)"
                                                        fill-rule="nonzero">
                                                        <g id="delete_2_line" transform="translate(576.000000, 192.000000)">
                                                            <path
                                                                d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                                                id="MingCute" fill-rule="nonzero"> </path>
                                                            <path
                                                                d="M14.2792,2 C15.1401,2 15.9044,2.55086 16.1766,3.36754 L16.7208,5 L20,5 C20.5523,5 21,5.44772 21,6 C21,6.55227 20.5523,6.99998 20,7 L19.9975,7.07125 L19.9975,7.07125 L19.1301,19.2137 C19.018,20.7837 17.7117,22 16.1378,22 L7.86224,22 C6.28832,22 4.982,20.7837 4.86986,19.2137 L4.00254,7.07125 C4.00083,7.04735 3.99998,7.02359 3.99996,7 C3.44769,6.99998 3,6.55227 3,6 C3,5.44772 3.44772,5 4,5 L7.27924,5 L7.82339,3.36754 C8.09562,2.55086 8.8599,2 9.72076,2 L14.2792,2 Z M17.9975,7 L6.00255,7 L6.86478,19.0712 C6.90216,19.5946 7.3376,20 7.86224,20 L16.1378,20 C16.6624,20 17.0978,19.5946 17.1352,19.0712 L17.9975,7 Z M10,10 C10.51285,10 10.9355092,10.386027 10.9932725,10.8833761 L11,11 L11,16 C11,16.5523 10.5523,17 10,17 C9.48715929,17 9.06449214,16.613973 9.00672766,16.1166239 L9,16 L9,11 C9,10.4477 9.44771,10 10,10 Z M14,10 C14.5523,10 15,10.4477 15,11 L15,16 C15,16.5523 14.5523,17 14,17 C13.4477,17 13,16.5523 13,16 L13,11 C13,10.4477 13.4477,10 14,10 Z M14.2792,4 L9.72076,4 L9.38743,5 L14.6126,5 L14.2792,4 Z"
                                                                id="形状" fill="#fcf8db"> </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    <?php endif; ?>
                                    <span
                                        class="comment-date"><?= date('Y-m-d H:i', strtotime($comment['created_at'])) ?></span>
                                </div>
                                <div class="comment-content">
                                    <?= htmlspecialchars($comment['content']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>まだコメントがありません。</p>
                <?php endif; ?>
                <h2>コメントする</h2>
                <form id="commentForm">
                    <input class="nickname" type="text" name="nickname" placeholder="ニックネーム">
                    <textarea name="comment" id="comment" cols="20" rows="10" placeholder="コメントを入力してください"></textarea>
                    <input type="hidden" name="parkId" value="<?= $id ?>">
                    <input type="hidden" name="email" value="<?= $_SESSION['email'] ?>">
                    <button id="submitBtn" type="submit">コメントする</button>
                </form>
            </div>
            <span id="closeCommentPopup" class="close-comment-popup"><svg width="34px" height="34px" viewBox="0 0 24 24"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g id="Edit / Close_Circle">
                            <path id="Vector"
                                d="M9 9L11.9999 11.9999M11.9999 11.9999L14.9999 14.9999M11.9999 11.9999L9 14.9999M11.9999 11.9999L14.9999 9M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z"
                                stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </g>
                </svg></span>
        </div>
        <!-- Modal for enlarged image -->
        <div id="imageModal" class="modal">
            <div id="modalContent" class="modal-content" onclick="event.stopPropagation()">
                <img id="modalImage" class="modal-image">
            </div>
            <span id="closeModalBtn" class="close">
                <svg width="34px" height="34px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g id="Edit / Close_Circle">
                            <path id="Vector"
                                d="M9 9L11.9999 11.9999M11.9999 11.9999L14.9999 14.9999M11.9999 11.9999L9 14.9999M11.9999 11.9999L14.9999 9M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z"
                                stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </g>
                </svg>
            </span>
        </div>
        <div id="overlay"></div>
        <footer>
            <?php include 'include/footer.php' ?>
        </footer>
        <script src="js/menu.js"></script>
        <script src="js/search.js"></script>
        <script src="js/comment.js"></script>
        <script src="js/parklike.js"></script>
        <script src="js/background.js"></script>
        <script>
            function openModal(imageSrc) {
                const modal = document.getElementById("imageModal");
                const modalImage = document.getElementById("modalImage");
                modal.classList.add("show"); // Add the 'show' class to make it visible
                modalImage.src = imageSrc;
                document.body.style.overflow = 'hidden'; // Prevent body scroll
            }

            function closeModal() {
                const modal = document.getElementById("imageModal");
                modal.classList.remove("show"); // Remove the 'show' class to hide it
                document.body.style.overflow = ''; // Restore body scroll
            }

            // Thêm event listeners khi document load
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById("imageModal");
                const closeBtn = document.getElementById("closeModalBtn");

                // Đóng modal khi click vào nền
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });

                // Đóng modal khi click vào nút close
                closeBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    closeModal();
                });
            });
        </script>
    </div>
</body>

</html>