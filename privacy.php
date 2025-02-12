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

trackPageVisit('privacy.php');
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include 'include/head.php' ?>
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
            <div class="privacy-container">
                <h1>プライバシーポリシー (個人情報保護方針)</h1>
                <p>「GREEN
                    SPACE」は、個人情報の重要性を認識し、これを適切に保護することを重要な組織的負担としています。このプライバシーポリシーは、個人情報の収集、使用、伝達に関する方針を定め、お客様の個人情報を最大限保護することを目標としております。
                </p>


                <h2>1. 個人情報の定義</h2>
                <p>個人情報とは、身份を特定できる一人一人の情報であり、例えば姓名、住所、電話番号、メールアドレス、IPアドレスなどが含まれます。</p>

                <h2>2. 個人情報の収集方法</h2>
                <p>「GREEN SPACE」は、正当な手段で個人情報を収集します。お客様からご提供いただく情報は、対象とするサービスを提供するために限ります。</p>

                <h2>3. 個人情報の使用目的</h2>
                <p>「GREEN SPACE」は、収集した個人情報を、以下の目的のために使用します。</p>
                <ul>
                    <li>ウェブサイトの提供および改善</li>
                    <li>お客様からの問い合わせ対応</li>
                    <li>新しいサービスの案内</li>
                </ul>
                <h2>4. 個人情報の保管</h2>
                <p>個人情報の正確性を保つともに、不正アクセス、使用、汚捜、流出を防ぐため、適切な保守管理を行います。</p>

                <h2>5. 個人情報の提供の開示</h2>
                <p>「GREEN SPACE」は、法令に基づく報告事項を除き、お客様の同意なく個人情報を第三者に提供することはありません。</p>

                <h2>6. 個人情報の取り消し、修正</h2>
                <p>「GREEN SPACE」は、お客様から自身の個人情報の取り消しや修正のご要望があった場合、調査の上、通常の状況で実施します。</p>

                <h2>7. クッキーの使用</h2>
                <p>「GREEN SPACE」は、サービスの向上や情報認識のためにクッキーを使用します。クッキーの無効化を期する場合は、ブラウザの設定を変更して下さい。</p>

                <h2>8. プライバシーポリシーの改訂</h2>
                <p>「GREEN SPACE」は、法令の変更やサービス改善に伴い、このプライバシーポリシーを修正する場合があります。重要な変更がある場合は、ウェブサイトなどでお知らせします。</p>
            </div>
        </main>
        <div id="overlay"></div>
        <footer>
            <?php include 'include/footer.php' ?>
        </footer>
    </div>
        <script src="js/menu.js"></script>
        <script src="js/search.js"></script>
        <script src="js/background.js"></script>
</body>

</html>