<?php

require_once __DIR__ . '/class/UserData.php';
require_once __DIR__ . '/functions/verify.php';

ini_set('session.gc_maxlifetime', 259200);
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
    if (empty($password)) {
        $errormessages['password'] = 'パスワードを入力してください';
    }

    if (empty($errormessages)) {
        $user = UserData::getUser($email);
        if (!$user || !password_verify($password, $user->password)) {
            $errormessages['login'] = 'メールアドレスまたはパスワードが間違っています';
        } elseif ($user->status === 'banned') {
            $errormessages['login'] = 'このアカウントは利用停止されています';
        } else {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user->role;
            createToken($email);
            header('Location: index.php');
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Green Spaceは、緑の空間を提供するサービスです。">
    <meta name="keywords" content="緑の空間, 緑の空間を提供するサービス, イベント情報を提供するサービス">
    <meta name="author" content="Green Space">
    <title>Green Space</title>
    <link rel="shortcut icon" href="img/img/logoNotext.png" type="image/x-icon">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/style.css">
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
        <div class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="350"
                zoomAndPan="magnify" viewBox="95 100 180 180" height="250" preserveAspectRatio="xMidYMid meet"
                version="1.0">
                <defs>
                    <g />
                    <clipPath id="ab2bbe5ed7">
                        <path
                            d="M 90 128.476562 L 177.804688 128.476562 L 177.804688 246.226562 L 90 246.226562 Z M 90 128.476562 "
                            clip-rule="nonzero" />
                    </clipPath>
                    <clipPath id="17ec05a312">
                        <path
                            d="M 123.488281 137.679688 C 121.652344 137.679688 119.839844 137.769531 118.042969 137.945312 C 115.765625 131.929688 116.9375 128.476562 116.9375 128.476562 C 112.007812 134.199219 115.300781 142.097656 116.800781 149.503906 C 118.300781 156.910156 121.535156 164.886719 120.273438 172.34375 C 118.960938 180.042969 110.441406 186.839844 105.636719 192.992188 C 97.648438 203.230469 98.804688 214.738281 98.804688 214.738281 C 91.179688 199.265625 93.726562 174.285156 103.113281 154.867188 C 96.277344 164.058594 89.265625 179.046875 90.421875 199.609375 C 91.496094 218.800781 108.496094 234.304688 117.34375 238.90625 C 109.957031 230.59375 107.777344 217.824219 112.34375 207.628906 C 115.527344 200.515625 121.386719 195.035156 126.664062 189.292969 C 131.929688 183.554688 136.9375 176.910156 137.667969 169.148438 C 142.746094 176.828125 146.957031 184.324219 148.574219 191.898438 C 150.4375 200.636719 149.679688 210.328125 144.503906 217.617188 C 142.066406 221.046875 138.792969 223.769531 135.695312 226.621094 C 132.953125 229.144531 130.28125 231.867188 128.527344 235.132812 C 127.550781 227.300781 132.242188 218.355469 136.847656 209.609375 C 143.378906 197.195312 137.964844 188.476562 137.964844 188.476562 C 142.105469 203.308594 123.488281 216.609375 123.488281 233.800781 C 123.488281 239.609375 125.210938 243.582031 126.988281 246.414062 C 155.410156 244.609375 177.914062 220.988281 177.914062 192.105469 C 177.902344 162.046875 153.535156 137.679688 123.488281 137.679688 Z M 123.488281 137.679688 "
                            clip-rule="nonzero" />
                    </clipPath>
                    <clipPath id="1c787a02c0">
                        <path d="M 69.054688 141 L 124 141 L 124 246.226562 L 69.054688 246.226562 Z M 69.054688 141 "
                            clip-rule="nonzero" />
                    </clipPath>
                    <clipPath id="3ddf1fd71a">
                        <path
                            d="M 88.84375 212.480469 C 82.058594 195.328125 82.660156 175.292969 91.257812 158.96875 C 94.691406 152.460938 99.199219 146.652344 104.167969 141.21875 C 83.644531 149.011719 69.0625 168.851562 69.0625 192.105469 C 69.0625 222.015625 93.183594 246.285156 123.035156 246.519531 C 107.816406 240.347656 95.203125 228.554688 88.84375 212.480469 Z M 88.84375 212.480469 "
                            clip-rule="nonzero" />
                    </clipPath>
                </defs>
                <g clip-path="url(#ab2bbe5ed7)">
                    <g clip-path="url(#17ec05a312)">
                        <path fill="#99e631"
                            d="M 177.804688 128.476562 L 177.804688 246.226562 L 89.265625 246.226562 L 89.265625 128.476562 Z M 177.804688 128.476562 "
                            fill-opacity="1" fill-rule="nonzero" />
                    </g>
                </g>
                <g clip-path="url(#1c787a02c0)">
                    <g clip-path="url(#3ddf1fd71a)">
                        <path fill="#99e631"
                            d="M 123.035156 141.21875 L 123.035156 246.226562 L 69.0625 246.226562 L 69.0625 141.21875 Z M 123.035156 141.21875 "
                            fill-opacity="1" fill-rule="nonzero" />
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(187.289011, 190.592858)">
                        <g>
                            <path
                                d="M 19.09375 -17.234375 C 18.75 -18.421875 18.117188 -19.351562 17.203125 -20.03125 C 16.285156 -20.707031 15.140625 -21.046875 13.765625 -21.046875 C 11.816406 -21.046875 10.238281 -20.328125 9.03125 -18.890625 C 7.820312 -17.453125 7.21875 -15.40625 7.21875 -12.75 C 7.21875 -10.09375 7.8125 -8.035156 9 -6.578125 C 10.1875 -5.128906 11.789062 -4.40625 13.8125 -4.40625 C 15.601562 -4.40625 17.007812 -4.867188 18.03125 -5.796875 C 19.050781 -6.734375 19.578125 -7.992188 19.609375 -9.578125 L 14.140625 -9.578125 L 14.140625 -13.625 L 24.796875 -13.625 L 24.796875 -10.421875 C 24.796875 -8.191406 24.320312 -6.269531 23.375 -4.65625 C 22.4375 -3.039062 21.140625 -1.800781 19.484375 -0.9375 C 17.828125 -0.0820312 15.925781 0.34375 13.78125 0.34375 C 11.394531 0.34375 9.296875 -0.179688 7.484375 -1.234375 C 5.679688 -2.296875 4.273438 -3.800781 3.265625 -5.75 C 2.265625 -7.695312 1.765625 -10.015625 1.765625 -12.703125 C 1.765625 -15.453125 2.289062 -17.804688 3.34375 -19.765625 C 4.394531 -21.722656 5.816406 -23.21875 7.609375 -24.25 C 9.410156 -25.28125 11.429688 -25.796875 13.671875 -25.796875 C 15.597656 -25.796875 17.335938 -25.429688 18.890625 -24.703125 C 20.453125 -23.972656 21.726562 -22.960938 22.71875 -21.671875 C 23.71875 -20.390625 24.332031 -18.910156 24.5625 -17.234375 Z M 19.09375 -17.234375 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(213.905792, 190.592858)">
                        <g>
                            <path
                                d="M 2.21875 0 L 2.21875 -25.453125 L 12.25 -25.453125 C 15.144531 -25.453125 17.390625 -24.695312 18.984375 -23.1875 C 20.578125 -21.6875 21.375 -19.671875 21.375 -17.140625 C 21.375 -15.398438 20.984375 -13.910156 20.203125 -12.671875 C 19.429688 -11.441406 18.320312 -10.515625 16.875 -9.890625 L 22.28125 0 L 16.34375 0 L 11.515625 -9.03125 L 7.59375 -9.03125 L 7.59375 0 Z M 7.59375 -13.34375 L 11.25 -13.34375 C 14.300781 -13.34375 15.828125 -14.609375 15.828125 -17.140625 C 15.828125 -19.753906 14.289062 -21.0625 11.21875 -21.0625 L 7.59375 -21.0625 Z M 7.59375 -13.34375 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(236.869299, 190.592858)">
                        <g>
                            <path
                                d="M 2.21875 0 L 2.21875 -25.453125 L 19.359375 -25.453125 L 19.359375 -21.015625 L 7.59375 -21.015625 L 7.59375 -14.953125 L 18.484375 -14.953125 L 18.484375 -10.515625 L 7.59375 -10.515625 L 7.59375 -4.4375 L 19.421875 -4.4375 L 19.421875 0 Z M 2.21875 0 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(258.30439, 190.592858)">
                        <g>
                            <path
                                d="M 2.21875 0 L 2.21875 -25.453125 L 19.359375 -25.453125 L 19.359375 -21.015625 L 7.59375 -21.015625 L 7.59375 -14.953125 L 18.484375 -14.953125 L 18.484375 -10.515625 L 7.59375 -10.515625 L 7.59375 -4.4375 L 19.421875 -4.4375 L 19.421875 0 Z M 2.21875 0 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(279.739482, 190.592858)">
                        <g>
                            <path
                                d="M 23.5 -25.453125 L 23.5 0 L 18.859375 0 L 7.78125 -16.015625 L 7.59375 -16.015625 L 7.59375 0 L 2.21875 0 L 2.21875 -25.453125 L 6.9375 -25.453125 L 17.921875 -9.453125 L 18.140625 -9.453125 L 18.140625 -25.453125 Z M 23.5 -25.453125 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(187.289011, 228.755639)">
                        <g>
                            <path
                                d="M 13.734375 -15.546875 C 13.648438 -16.398438 13.28125 -17.066406 12.625 -17.546875 C 11.976562 -18.023438 11.101562 -18.265625 10 -18.265625 C 8.875 -18.265625 8.007812 -18.03125 7.40625 -17.5625 C 6.800781 -17.101562 6.5 -16.523438 6.5 -15.828125 C 6.488281 -15.046875 6.820312 -14.453125 7.5 -14.046875 C 8.1875 -13.640625 9.003906 -13.328125 9.953125 -13.109375 L 11.90625 -12.640625 C 13.175781 -12.359375 14.300781 -11.945312 15.28125 -11.40625 C 16.269531 -10.863281 17.046875 -10.164062 17.609375 -9.3125 C 18.171875 -8.46875 18.453125 -7.441406 18.453125 -6.234375 C 18.441406 -4.234375 17.691406 -2.640625 16.203125 -1.453125 C 14.722656 -0.273438 12.648438 0.3125 9.984375 0.3125 C 7.335938 0.3125 5.222656 -0.289062 3.640625 -1.5 C 2.066406 -2.707031 1.25 -4.488281 1.1875 -6.84375 L 5.65625 -6.84375 C 5.738281 -5.75 6.171875 -4.925781 6.953125 -4.375 C 7.734375 -3.832031 8.722656 -3.5625 9.921875 -3.5625 C 11.097656 -3.5625 12.035156 -3.804688 12.734375 -4.296875 C 13.429688 -4.796875 13.785156 -5.445312 13.796875 -6.25 C 13.785156 -6.976562 13.460938 -7.539062 12.828125 -7.9375 C 12.191406 -8.34375 11.28125 -8.6875 10.09375 -8.96875 L 7.71875 -9.5625 C 5.875 -10.007812 4.421875 -10.710938 3.359375 -11.671875 C 2.296875 -12.628906 1.765625 -13.910156 1.765625 -15.515625 C 1.765625 -16.835938 2.117188 -17.992188 2.828125 -18.984375 C 3.546875 -19.972656 4.53125 -20.738281 5.78125 -21.28125 C 7.03125 -21.832031 8.445312 -22.109375 10.03125 -22.109375 C 11.65625 -22.109375 13.070312 -21.832031 14.28125 -21.28125 C 15.488281 -20.726562 16.429688 -19.957031 17.109375 -18.96875 C 17.785156 -17.988281 18.132812 -16.847656 18.15625 -15.546875 Z M 13.734375 -15.546875 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(206.933834, 228.755639)">
                        <g>
                            <path
                                d="M 1.890625 0 L 1.890625 -21.8125 L 10.5 -21.8125 C 12.15625 -21.8125 13.566406 -21.5 14.734375 -20.875 C 15.898438 -20.25 16.789062 -19.378906 17.40625 -18.265625 C 18.019531 -17.148438 18.328125 -15.867188 18.328125 -14.421875 C 18.328125 -12.972656 18.015625 -11.695312 17.390625 -10.59375 C 16.765625 -9.488281 15.859375 -8.625 14.671875 -8 C 13.492188 -7.382812 12.066406 -7.078125 10.390625 -7.078125 L 6.515625 -7.078125 L 6.515625 0 Z M 6.515625 -10.765625 L 9.640625 -10.765625 C 10.960938 -10.765625 11.945312 -11.101562 12.59375 -11.78125 C 13.25 -12.46875 13.578125 -13.347656 13.578125 -14.421875 C 13.578125 -15.515625 13.25 -16.390625 12.59375 -17.046875 C 11.945312 -17.710938 10.957031 -18.046875 9.625 -18.046875 L 6.515625 -18.046875 Z M 6.515625 -10.765625 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(226.365592, 228.755639)">
                        <g>
                            <path
                                d="M 5.65625 0 L 0.71875 0 L 8.25 -21.8125 L 14.1875 -21.8125 L 21.71875 0 L 16.765625 0 L 15.15625 -4.96875 L 7.28125 -4.96875 Z M 8.453125 -8.578125 L 13.984375 -8.578125 L 11.296875 -16.828125 L 11.140625 -16.828125 Z M 8.453125 -8.578125 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(248.801607, 228.755639)">
                        <g>
                            <path
                                d="M 21.140625 -14.1875 L 16.484375 -14.1875 C 16.304688 -15.382812 15.789062 -16.320312 14.9375 -17 C 14.09375 -17.6875 13.039062 -18.03125 11.78125 -18.03125 C 10.09375 -18.03125 8.738281 -17.410156 7.71875 -16.171875 C 6.695312 -14.929688 6.1875 -13.175781 6.1875 -10.90625 C 6.1875 -8.582031 6.695312 -6.8125 7.71875 -5.59375 C 8.75 -4.382812 10.09375 -3.78125 11.75 -3.78125 C 12.976562 -3.78125 14.019531 -4.097656 14.875 -4.734375 C 15.726562 -5.378906 16.265625 -6.285156 16.484375 -7.453125 L 21.140625 -7.4375 C 20.984375 -6.101562 20.507812 -4.84375 19.71875 -3.65625 C 18.925781 -2.476562 17.851562 -1.523438 16.5 -0.796875 C 15.15625 -0.0664062 13.546875 0.296875 11.671875 0.296875 C 9.722656 0.296875 7.984375 -0.140625 6.453125 -1.015625 C 4.929688 -1.898438 3.726562 -3.175781 2.84375 -4.84375 C 1.957031 -6.507812 1.515625 -8.53125 1.515625 -10.90625 C 1.515625 -13.289062 1.960938 -15.316406 2.859375 -16.984375 C 3.753906 -18.648438 4.96875 -19.921875 6.5 -20.796875 C 8.03125 -21.671875 9.753906 -22.109375 11.671875 -22.109375 C 13.359375 -22.109375 14.878906 -21.796875 16.234375 -21.171875 C 17.585938 -20.554688 18.691406 -19.65625 19.546875 -18.46875 C 20.410156 -17.289062 20.941406 -15.863281 21.140625 -14.1875 Z M 21.140625 -14.1875 " />
                        </g>
                    </g>
                </g>
                <g fill="#99e631" fill-opacity="1">
                    <g transform="translate(271.365452, 228.755639)">
                        <g>
                            <path
                                d="M 1.890625 0 L 1.890625 -21.8125 L 16.59375 -21.8125 L 16.59375 -18.015625 L 6.515625 -18.015625 L 6.515625 -12.8125 L 15.84375 -12.8125 L 15.84375 -9.015625 L 6.515625 -9.015625 L 6.515625 -3.796875 L 16.640625 -3.796875 L 16.640625 0 Z M 1.890625 0 " />
                        </g>
                    </g>
                </g>
            </svg>
            <h1>
                GREEN SPACEは、<br>公園の情報を共有するサイトです。
            </h1>
        </div>
        <div class="login-register-form">
            <form action="login.php" method="post" aria-label="ログインフォーム">
                <h2>ログイン</h2>
                <div class="input-div">
                    <div>
                        <label for="email">メールアドレス</label>
                        <input type="email" name="email" id="email" placeholder="abc@gmail.com"
                            value="<?= htmlspecialchars($email ?? '') ?>" autocomplete="email" aria-label="メールアドレス">
                        <p><?= htmlspecialchars($errormessages['email'] ?? '') ?></p>
                    </div>
                    <div>
                        <label for="password">パスワード</label>
                        <input type="password" name="password" id="password" placeholder="********"
                            value="<?= htmlspecialchars($password ?? '') ?>" autocomplete="current-password" aria-label="パスワード">
                        <p><?= htmlspecialchars($errormessages['password'] ?? '') ?></p>
                    </div>
                </div>
                <p><?= htmlspecialchars($errormessages['login'] ?? '') ?></p>
                <div class="button-area">
                    <button class="glow-on-hover" type="submit" name="submit-button" aria-label="ログイン">ログイン</button>
                </div>
                <div class="second-button"><a href="register.php" aria-label="アカウントを作成">アカウントを作成</a></div>
            </form>
        </div>
    </div>
    <script src="js/background.js"></script>
</body>

</html>