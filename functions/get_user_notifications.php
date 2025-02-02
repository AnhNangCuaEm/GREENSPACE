<?php
session_start();
require_once __DIR__ . '/../class/Database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

try {
    $pdo = Database::getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy thông báo của user từ notification_recipients và notifications
    $sql = "SELECT n.id, n.title, n.content, n.created_at, n.created_by, 
                   nr.is_read, nr.read_at
            FROM notifications n
            INNER JOIN notification_recipients nr ON n.id = nr.notification_id
            WHERE nr.recipient_email = ?
            ORDER BY n.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['email']]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($notifications)) {
        echo json_encode([
            'success' => true,
            'message' => 'No notifications found',
            'data' => []
        ]);
    } else {
        // Format dữ liệu trước khi trả về
        foreach ($notifications as &$notification) {
            // Thêm thông tin về thời gian tạo
            $notification['created_at_formatted'] = (new DateTime($notification['created_at']))
                ->format('Y年m月d日 H:i');

            // Thêm thông tin về thời gian đọc nếu có
            if ($notification['read_at']) {
                $notification['read_at_formatted'] = (new DateTime($notification['read_at']))
                    ->format('Y年m月d日 H:i');
            }

            // Rút gọn content nếu quá dài
            if (strlen($notification['content']) > 30) {
                $notification['short_content'] = mb_substr($notification['content'], 0, 30) . '...';
            } else {
                $notification['short_content'] = $notification['content'];
            }
        }

        // Đếm số thông báo chưa đọc
        $unreadCount = array_reduce($notifications, function ($carry, $item) {
            return $carry + ($item['is_read'] ? 0 : 1);
        }, 0);

        echo json_encode([
            'success' => true,
            'message' => 'Notifications retrieved successfully',
            'unread_count' => $unreadCount,
            'data' => $notifications
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}