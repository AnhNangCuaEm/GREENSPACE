<?php
require_once __DIR__ . '/functions/verify.php';
require_once __DIR__ . '/functions/track_visits.php';

session_start();

$email = verifyToken();
if (!$email) {
    header('Location: login.php');
    exit();
}

$_SESSION['email'] = $email;

trackPageVisit('contact.php');
?>

<!DOCTYPE html>
<html lang="ja">

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
            <div class="interactive"></div>
        </div>
    </div>
    <div class="content-wrapper">
        <?php include 'include/nav.php' ?>
        <main>
            <div class="feedback-form">
                <h1>フィードバック・問い合わせフォーム</h1>
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
                                <td><input type="radio" name="uiux" value="1" aria-label="とても良くない"></td>
                                <td><input type="radio" name="uiux" value="2" aria-label="良くない"></td>
                                <td><input type="radio" name="uiux" value="3" aria-label="普通"></td>
                                <td><input type="radio" name="uiux" value="4" aria-label="良かった"></td>
                                <td><input type="radio" name="uiux" value="5" aria-label="とても良かった"></td>
                            </tr>
                            <tr>
                                <td>内容</td>
                                <td><input type="radio" name="content" value="1" aria-label="とても良くない"></td>
                                <td><input type="radio" name="content" value="2" aria-label="良くない"></td>
                                <td><input type="radio" name="content" value="3" aria-label="普通"></td>
                                <td><input type="radio" name="content" value="4" aria-label="良かった"></td>
                                <td><input type="radio" name="content" value="5" aria-label="とても良かった"></td>
                            </tr>
                            <tr>
                                <td>全体的</td>
                                <td><input type="radio" name="overall" value="1" aria-label="とても良くない"></td>
                                <td><input type="radio" name="overall" value="2" aria-label="良くない"></td>
                                <td><input type="radio" name="overall" value="3" aria-label="普通"></td>
                                <td><input type="radio" name="overall" value="4" aria-label="良かった"></td>
                                <td><input type="radio" name="overall" value="5" aria-label="とても良かった"></td>
                            </tr>
                        </tbody>
                    </table>

                    <textarea name="content_text" placeholder="問い合わせ、フィードバックの内容..." aria-label="問い合わせ、フィードバックの内容..."></textarea>

                    <div class="button-area">
                        <button class="glow-on-hover" type="submit" name="submit-button" aria-label="送信">送信</button>
                    </div>
                </form>
            </div>
            <div class="result-popup" id="result" aria-label="送信結果"></div>
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