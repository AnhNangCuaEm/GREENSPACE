<?php

require_once __DIR__ . '/../class/Database.php';

session_start();

if (!isset($_SESSION['email'])) {
    die("Bạn cần đăng nhập để gửi phản hồi.");
}

$email = $_SESSION['email'];

//function to get feedback sent by user
try {
    $pdo = Database::getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uiux = $_POST['uiux'] ?? null;
    $content_rating = $_POST['content'] ?? null;
    $overall = $_POST['overall'] ?? null;
    $feedback_content = $_POST['content_text'] ?? null;

    // Kiểm tra dữ liệu
    if ($uiux && $content_rating && $overall) {
        try {
            // Chuẩn bị câu truy vấn
            $sql = "
                INSERT INTO feedback (uiux, email, content_rating, overall, feedback_content)
                VALUES (:uiux, :email, :content_rating, :overall, :feedback_content)
            ";
            $stmt = $pdo->prepare($sql);

            // Gắn giá trị vào truy vấn
            $stmt->bindParam(':email', $email, PDO::PARAM_STR); // Gửi kèm email từ session
            $stmt->bindParam(':uiux', $uiux, PDO::PARAM_INT);
            $stmt->bindParam(':content_rating', $content_rating, PDO::PARAM_INT);
            $stmt->bindParam(':overall', $overall, PDO::PARAM_INT);
            $stmt->bindParam(':feedback_content', $feedback_content, PDO::PARAM_STR);

            // Thực thi truy vấn
            if ($stmt->execute()) {
                echo "Phản hồi của bạn đã được lưu thành công!";
                header("Refresh: 5; url=../index.php"); // Redirect after 5 seconds
                exit(); // Ensure no further code is executed
            } else {
                echo "Đã xảy ra lỗi khi lưu phản hồi.";
            }
        } catch (PDOException $e) {
            echo "Lỗi khi lưu phản hồi: " . $e->getMessage();
        }
    } else {
        echo "Vui lòng chọn đầy đủ các tùy chọn và nhập nội dung.";
    }
}
?>