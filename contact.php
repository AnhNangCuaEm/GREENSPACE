<?php

session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

?>

<html>
<?php include 'include/head.php' ?>

<body>
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
    <footer>
        <?php include 'include/footer.php' ?>
    </footer>
    <script src="js/menu.js"></script>
    <script src="js/slideshow.js"></script>
    <script src="js/index.js"></script>
</body>

</html>