<?php
//this is dashboard page to manage user, park, event only admin can access

require_once __DIR__ . '/../class/UserData.php';
require_once __DIR__ . '/../class/ParkData.php';
require_once __DIR__ . '/../class/EventData.php';
require_once __DIR__ . '/../functions/verify.php';

session_start();


$email = verifyToken(); // Kiểm tra token trong cookie
if (!$email) {
    header('Location: login.php'); // Chuyển hướng nếu token không hợp lệ
    exit();
}

// Nếu cần, lưu lại email trong session để dùng trong phiên hiện tại
$_SESSION['email'] = $email;

$email = $_SESSION['email'];
$user = UserData::getProfile();

// Check if user is admin
if ($user->role !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="../img/img/logoNotext.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h1>Admin Dashboard</h1>
            <button class="nav-btn active" data-section="users">User Manager</button>
            <button class="nav-btn" data-section="parks">Park Manager</button>
            <button class="nav-btn" data-section="events">Event Manager</button>
            <!-- back to profile page -->
            <button class="nav-btn" onclick="window.location.href='../profile.php'">Back to Profile</button>
        </div>
        
        <div class="content">
            <div id="users-section" class="content-section active"></div>
            <div id="parks-section" class="content-section"></div>
            <div id="events-section" class="content-section"></div>
        </div>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>

