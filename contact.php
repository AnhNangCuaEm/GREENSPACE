<?php
require_once __DIR__ . '/functions/verify.php';
require_once __DIR__ . '/functions/track_visits.php';

session_start();

$email = verifyToken(); // Kiểm tra token trong cookie
if (!$email) {
    header('Location: login.php'); // Chuyển hướng nếu token không hợp lệ
    exit();
}

// Nếu cần, lưu lại email trong session để dùng trong phiên hiện tại
$_SESSION['email'] = $email;

trackPageVisit('contact.php');
?>

<html>

<head>
    <?php include 'include/head.php' ?>
    <link rel="stylesheet" href="css/contact.css">
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
            <div class="g3"></div>
            <div class="interactive"></div>
        </div>
    </div>
    <div class="content-wrapper">
        <?php include 'include/nav.php' ?>
        <main>
            <div class="feedback-form">
                <h1>フィードバック・問い合わせフォーム</h1>

                <!-- Phần 1: Bảng đánh giá -->
                <form id="myForm">
                    <table>
                        <thead>
                            <tr>
                                <th>評価</th>
                                <th>とても良くない</th>
                                <th>良くない</th>
                                <th>普通</th>
                                <th>良かった</th>
                                <th>とても良かった</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>UI/UX</td>
                                <td><input type="radio" name="uiux" value="1"></td>
                                <td><input type="radio" name="uiux" value="2"></td>
                                <td><input type="radio" name="uiux" value="3"></td>
                                <td><input type="radio" name="uiux" value="4"></td>
                                <td><input type="radio" name="uiux" value="5"></td>
                            </tr>
                            <tr>
                                <td>内容</td>
                                <td><input type="radio" name="content" value="1"></td>
                                <td><input type="radio" name="content" value="2"></td>
                                <td><input type="radio" name="content" value="3"></td>
                                <td><input type="radio" name="content" value="4"></td>
                                <td><input type="radio" name="content" value="5"></td>
                            </tr>
                            <tr>
                                <td>全体的</td>
                                <td><input type="radio" name="overall" value="1"></td>
                                <td><input type="radio" name="overall" value="2"></td>
                                <td><input type="radio" name="overall" value="3"></td>
                                <td><input type="radio" name="overall" value="4"></td>
                                <td><input type="radio" name="overall" value="5"></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Phần 2: Text Area -->
                    <textarea name="content_text" placeholder="問い合わせ、フィードバックの内容..."></textarea>

                    <!-- Nút Submit -->
                    <div class="button-area">
                        <button class="glow-on-hover" type="submit" name="submit-button">送信</button>
                    </div>
                </form>
            </div>
            <div class="result-popup" id="result"></div>
        </main>
        <div id="overlay"></div>
        <footer>
            <?php include 'include/footer.php' ?>
        </footer>
    </div>
    <script src="js/background.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/search.js"></script>
    <script src="js/form.js"></script>
</body>

</html>