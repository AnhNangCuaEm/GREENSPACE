<?php
require_once __DIR__ . '/../class/Database.php';

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$email = $_SESSION['email'];

try {
    $pdo = Database::getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fail to connect to Database " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uiux = $_POST['uiux'] ?? null;
    $content_rating = $_POST['content'] ?? null;
    $overall = $_POST['overall'] ?? null;
    $feedback_content = $_POST['content_text'] ?? null;

    if ($uiux && $content_rating && $overall) {
        try {
            $sql = "
                INSERT INTO feedback (uiux, email, content_rating, overall, feedback_content)
                VALUES (:uiux, :email, :content_rating, :overall, :feedback_content)
            ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':uiux', $uiux, PDO::PARAM_INT);
            $stmt->bindParam(':content_rating', $content_rating, PDO::PARAM_INT);
            $stmt->bindParam(':overall', $overall, PDO::PARAM_INT);
            $stmt->bindParam(':feedback_content', $feedback_content, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "送信完了!";
            } else {
                echo "送信失敗!";
            }
        } catch (PDOException $e) {
            echo "保存失敗: " . $e->getMessage();
        }
    } else {
        echo "すべて選択してください!";
    }
}
?>