<?php

require_once __DIR__ . '/class/UserData.php';
require_once __DIR__ . '/class/ParkData.php';
require_once __DIR__ . '/class/ParkImageData.php';
require_once __DIR__ . '/functions/verify.php';
require_once __DIR__ . '/functions/parklike.php';
require_once __DIR__ . '/functions/comment.php';

session_start();

$email = verifyToken(); // Kiểm tra token trong cookie
if (!$email) {
    header('Location: login.php'); // Chuyển hướng nếu token không hợp lệ
    exit();
}

// Nếu cần, lưu lại email trong session để dùng trong phiên hiện tại
$_SESSION['email'] = $email;

$isLiked = false; // Khởi tạo biến $isLiked
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $parks = ParkData::getPark($id);
    $images = ParkImageData::getParkImages($id);
    $totalpark = ParkData::getallParks();
    $likeCount = countLikes($id);

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
    <?php include 'include/nav.php' ?>
    <main>
        <div class="park-detail">
            <div class="park-detail-image">
                <img src="<?= htmlspecialchars($parks->thumbnail) ?>" alt="公園の画像">
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
                    <a href="?id=<?= ($id <= 1) ? count($totalpark) : $id - 1 ?>"><button><svg fill="#000000"
                                height="24px" width="24px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
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
                    <a href="?id=<?= ($id >= count($totalpark)) ? 1 : $id + 1 ?>"><button>次へ<svg fill="#000000"
                                height="24px" width="24px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
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
                                    stroke="#fcf8db" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                <?php foreach ($images as $imagePath): ?>
                    <div class="park-images-box" onclick="openModal('<?= htmlspecialchars($imagePath) ?>')">
                        <img src="<?= htmlspecialchars($imagePath) ?>" alt="公園の画像">
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
                                    <svg class="delete-comment" data-comment-id="<?= $comment['id'] ?>" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <title>delete_2_line</title>
                                        <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g id="System" transform="translate(-576.000000, -192.000000)" fill-rule="nonzero">
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
                                <span class="comment-date"><?= date('Y-m-d H:i', strtotime($comment['created_at'])) ?></span>
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
                    <g clip-path="url(#clip0_429_11081)">
                        <circle cx="12" cy="11.9999" r="9" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round"></circle>
                        <path d="M14 10.0001L10 14.0001" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M10 10.0001L14 14.0001" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0_429_11081">
                            <rect width="24" height="24" fill="white"></rect>
                        </clipPath>
                    </defs>
                </g>
            </svg></span>
    </div>
    <!-- Modal for enlarged image -->
    <div id="imageModal" class="modal" onclick="closeModal()">
        <img class="modal-content" id="modalImage">
        <span class="close" onclick="closeModal()"><svg width="34px" height="34px" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <g clip-path="url(#clip0_429_11081)">
                        <circle cx="12" cy="11.9999" r="9" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round"></circle>
                        <path d="M14 10.0001L10 14.0001" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M10 10.0001L14 14.0001" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0_429_11081">
                            <rect width="24" height="24" fill="white"></rect>
                        </clipPath>
                    </defs>
                </g>
            </svg></span>
    </div>
    <div id="overlay"></div>
    <footer>
        <?php include 'include/footer.php' ?>
    </footer>
    <script src="js/menu.js"></script>
    <script src="js/search.js"></script>
    <script src="js/comment.js"></script>
    <script src="js/parklike.js"></script>
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
    </script>
</body>

</html>