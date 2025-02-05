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

    $sql = "SELECT n.id, n.title, n.content, n.created_at, 
                   nr.is_read, nr.read_at, n.is_active
            FROM notifications n
            INNER JOIN notification_recipients nr ON n.id = nr.notification_id
            WHERE nr.recipient_email = ? 
            AND nr.is_deleted = 0
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
        // Format data before returning
        foreach ($notifications as &$notification) {
            // Add time information
            $notification['created_at_formatted'] = (new DateTime($notification['created_at']))
                ->format('Y年m月d日 H:i');

            // Add time information if read
            if ($notification['read_at']) {
                $notification['read_at_formatted'] = (new DateTime($notification['read_at']))
                    ->format('Y年m月d日 H:i');
            }

            // Shorten content if too long
            if (strlen($notification['content']) > 30) {
                $notification['short_content'] = mb_substr($notification['content'], 0, 30) . '...';
            } else {
                $notification['short_content'] = $notification['content'];
            }
        }

        // Count unread notifications
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