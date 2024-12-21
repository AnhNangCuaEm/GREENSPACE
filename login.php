<?php

require_once __DIR__ . '/class/UserData.php';

session_start();

$errormessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $errormessages['email'] = 'メールアドレスを入力してください';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errormessages['email'] = 'メールアドレスフォーマットが間違っています';
    }
    if (empty($password) || strlen($password) < 8) {
        $errormessages['password'] = '８文字以上のパスワードを入力してください';
    }

    if (empty($errormessages)) {
        $user = UserData::getUser($email);
        if (!$user || !password_verify($password, $user->password)) {
            $errormessages['login'] = 'メールアドレスまたはパスワードが間違っています';
        } else {
            $_SESSION['email'] = $email;
            header('Location: index.php');
            exit;
        }
    }
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Space</title>
    <link rel="shortcut icon" href="img/img/logoNotext.png" type="image/x-icon">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div>
        <img src="./img/img/logo.png" alt="">
    </div>
    <div class="login-register-form">
        <form action="login.php" method="post">
            <div>
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($email ?? '') ?>">
                <p style="color: red;"><?= htmlspecialchars($errormessages['email'] ?? '') ?></p>
            </div>
            <div>
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password" value="<?= htmlspecialchars($password ?? '') ?>">
                <p style="color: red;"><?= htmlspecialchars($errormessages['password'] ?? '') ?></p>
            </div>
            <p style="color: red;"><?= htmlspecialchars($errormessages['login'] ?? '') ?></p>
            <button type="submit">ログイン</button>
            <a href="register.php"><p>録登</p></a>
        </form>
    </div>
</body>

</html>