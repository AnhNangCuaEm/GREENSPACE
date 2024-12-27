<?php

require_once __DIR__ . '/../class/Database.php';

function createToken(string $email): void {
    $token = bin2hex(random_bytes(16)); // Tạo token ngẫu nhiên
    $pdo = Database::getConnection();

    // Thêm token vào bảng login_tokens
    $state = $pdo->prepare('INSERT INTO login_tokens (email, token) VALUES (:email, :token)');
    $state->bindValue(':email', $email, PDO::PARAM_STR);
    $state->bindValue(':token', $token, PDO::PARAM_STR);
    $state->execute();

    // Lưu token vào cookie (7 ngày)
    setcookie('login_token', $token, time() + 604800, '/', '', false, true);
}

function verifyToken(): ?string {
    if (!isset($_COOKIE['login_token'])) {
        return null; // Cookie không tồn tại
    }

    $token = $_COOKIE['login_token'];
    $pdo = Database::getConnection();

    // Kiểm tra token trong bảng login_tokens
    $state = $pdo->prepare('SELECT email FROM login_tokens WHERE token = :token');
    $state->bindValue(':token', $token, PDO::PARAM_STR);
    $state->execute();

    $result = $state->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['email']; // Trả về email nếu token hợp lệ
    }

    return null; // Token không hợp lệ
}

function logout(): void {
    if (isset($_COOKIE['login_token'])) {
        $pdo = Database::getConnection();
        $state = $pdo->prepare('DELETE FROM login_tokens WHERE token = :token');
        $state->bindValue(':token', $_COOKIE['login_token'], PDO::PARAM_STR);
        $state->execute();

        // Xóa cookie
        setcookie('login_token', '', time() - 3600, '/', '', true, true);
    }

    header('Location: login.php'); // Chuyển hướng về trang đăng nhập
    exit();
}


