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
        <div class="interactive"></div>
    </div>
    </div>
    <div class="content-wrapper">
        <?php include 'include/nav.php' ?>
        <main>
            <div class="privacy-container">
                <h1>プライバシーポリシー (個人情報保護方針)</h1>
                <p>「GREEN SPACE」は、学習目的で開発されたプロジェクトです。本プロジェクトでは、個人情報の重要性を認識し、適切に取り扱うことを心がけています。このプライバシーポリシーは、個人情報の収集、使用、管理に関する方針を定めたものです。
                </p>


                <h2>1. 収集する情報</h2>
                <p>本プロジェクトでは、以下のような情報を収集する場合があります。</p>
                <ul>
                    <li>ユーザーが入力した氏名、メールアドレス、パスワードなどの登録情報</li>
                    <li>サイトの利用状況に関する情報(IPアドレス、クッキーなど)</li>
                </ul>

                <h2>2. 個人情報の利用目的</h2>
                <p>収集した情報は、以下の目的のために使用されます。</p>
                <ul>
                    <li>ウェブサイトの提供および改善</li>
                    <li>ユーザーサポート（お問い合わせ対応など）</li>
                    <li>学習・研究目的でのデータ分析（匿名化された情報を使用）</li>
                </ul>

                <h2>3. 個人情報の管理</h2>
                <p>本プロジェクトでは、個人情報の正確性を保つとともに、不正アクセスや情報の漏洩を防ぐために、適切な管理を行います。ただし、学習目的のプロジェクトであるため、セキュリティ対策は完全ではない点をご理解ください。</p>

                <h2>4. 第三者提供について</h2>
                <p>本プロジェクトでは、法令に基づく場合を除き、ユーザーの同意なく個人情報を第三者に提供することはありません。</p>

                <h2>5. ユーザーの権利</h2>
                <p>ユーザーは自身の登録情報の修正・削除を求めることができます。必要な場合は、お問い合わせください。</p>

                <h2>6. クッキーの使用</h2>
                <p>本プロジェクトでは、利便性向上のためクッキーを使用する場合があります。クッキーの無効化を希望する場合は、ブラウザの設定を変更してください。</p>

                <h2>7. プライバシーポリシーの変更</h2>
                <p>本プロジェクトは学習目的で運営されており、サービスの改善に伴いプライバシーポリシーを変更する場合があります。重要な変更がある場合は、サイト上でお知らせします。</p>
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