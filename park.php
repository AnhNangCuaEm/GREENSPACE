<?php

require_once __DIR__ . '/class/ParkData.php';
require_once __DIR__ . '/class/ParkImageData.php';
require_once __DIR__ . '/functions/verify.php';
require_once __DIR__ . '/functions/parklike.php';

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
                    <p><span>面積:</span>&nbsp;<?= htmlspecialchars($parks->area) ?></p>
                    <p><?= htmlspecialchars($parks->description) ?></p>
                    <div class="park-like-box">
                        <div id="likeCount"><?= htmlspecialchars($likeCount) ?></div>
                        <svg id="likeSvg" width="34px" height="34px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" 
                            style="fill: <?= $isLiked ? '#fcf8db' : 'none' ?>;">
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
                    <div class="park-detail-nav">
                        <a href="?id=<?= ($id <= 1) ? count($totalpark) : $id - 1 ?>"><button><svg fill="#000000"
                                    height="24px" width="24px" version="1.1" id="Capa_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 55.753 55.753" xml:space="preserve">
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
                                    height="24px" width="24px" version="1.1" id="Capa_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 55.752 55.752" xml:space="preserve">
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
        </main>
        <!-- Modal for enlarged image -->
        <div id="imageModal" class="modal" onclick="closeModal()">
            <img class="modal-content" id="modalImage">
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div id="overlay"></div>
        <footer>
            <?php include 'include/footer.php' ?>
        </footer>
    <script src="js/menu.js"></script>
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