<?php
//this is dashboard page to manage user, park, event only admin can access

require_once __DIR__ . '/../class/UserData.php';
require_once __DIR__ . '/../class/ParkData.php';
require_once __DIR__ . '/../class/EventData.php';
require_once __DIR__ . '/../class/ParkImageData.php';
require_once __DIR__ . '/../functions/verify.php';

session_start();

$email = verifyToken(); // Kiểm tra token trong cookie
if (!$email) {
    header('Location: login.php'); // Chuyển hướng nếu token không hợp lệ
    exit();
}
// Kiểm tra quyền admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

$_SESSION['email'] = $email;

$email = $_SESSION['email'];
$user = UserData::getProfile();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="../img/img/logoNotext.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="admin-container">
        <div class="sidebar">
            <h1>Admin Dashboard</h1>
            <button class="nav-btn active" data-section="dashboard">Dashboard</button>
            <button class="nav-btn" data-section="users">User Manager</button>
            <button class="nav-btn" data-section="parks">Park Manager</button>
            <button class="nav-btn" data-section="events">Event Manager</button>
            <button class="nav-btn" data-section="feedbacks">Feedbacks</button>
            <button class="nav-btn" data-section="notifications">Notifications</button>
            <button class="nav-btn" onclick="window.location.href='../profile.php'">Back to Profile</button>
        </div>

        <div class="content">
            <div id="dashboard-section" class="content-section "></div>
            <div id="users-section" class="content-section active"></div>
            <div id="parks-section" class="content-section"></div>
            <div id="events-section" class="content-section"></div>
            <div id="feedbacks-section" class="content-section"></div>
            <div id="notifications-section" class="content-section"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/admin.js"></script>
</body>

</html>