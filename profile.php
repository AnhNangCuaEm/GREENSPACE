<?php

require_once __DIR__ . '/class/UserData.php';

session_start();


if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];
$user = UserData::getUser();

?>

<html>

<head>
    <?php include 'include/head.php' ?>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <?php include 'include/nav.php' ?>
    <main>
        <div class="profile-container">
            <div class="avatar-box">
                <img src="<?php echo htmlspecialchars($user->avatar); ?>" alt="User Avatar">
                <button class="changeAvtBtn">変更</button>
            </div>
            <div class="user-box">
                <div class="user-info">
                    <p>お名前:<?php echo htmlspecialchars($user->name); ?></p>
                    <p>メールアドレス: <?php echo htmlspecialchars($user->email); ?></p>
                    <p>電話番号: <?php echo ($user->phone != 0) ? htmlspecialchars($user->phone) : ''; ?></p>
                    <p>住所: <?php echo htmlspecialchars($user->address); ?></p>
                </div>
                <button class="editBtn">編集<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path
                                d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </g>
                    </svg></button>
            </div>
        </div>
    </main>
    <footer>
        <?php include 'include/footer.php' ?>
    </footer>
    <script src="js/menu.js"></script>
    <script src="js/slideshow.js"></script>
    <script src="js/index.js"></script>
</body>

</html>