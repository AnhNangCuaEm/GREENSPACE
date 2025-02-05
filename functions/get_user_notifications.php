<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log the start of the script
error_log("Starting get_user_notifications.php");

// Start session and set headers
session_start();
header('Content-Type: application/json');

// Debug session
error_log("Session status: " . session_status());
error_log("Session email: " . (isset($_SESSION['email']) ? $_SESSION['email'] : 'not set'));

try {
    // Check session
    if (!isset($_SESSION['email'])) {
        throw new Exception('Session not found - user not logged in');
    }

    // Debug database connection
    error_log("Attempting to connect to database...");
    require_once __DIR__ . '/../class/Database.php';
    
    $pdo = Database::getConnection();
    if (!$pdo) {
        throw new Exception('Database connection failed');
    }
    error_log("Database connection successful");

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Debug query parameters
    error_log("Executing query for email: " . $_SESSION['email']);

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

    error_log("Query executed successfully. Found " . count($notifications) . " notifications");

    if (empty($notifications)) {
        echo json_encode([
            'success' => true,
            'message' => 'No notifications found',
            'data' => [],
            'unread_count' => 0
        ]);
        error_log("Returning empty notifications response");
        exit;
    }

    // Format notifications
    foreach ($notifications as &$notification) {
        $notification['created_at_formatted'] = (new DateTime($notification['created_at']))
            ->format('Y年m月d日 H:i');

        if ($notification['read_at']) {
            $notification['read_at_formatted'] = (new DateTime($notification['read_at']))
                ->format('Y年m月d日 H:i');
        }

            // Content is already processed in database, no need to shorten
            $notification['short_content'] = $notification['content'];
        }

    // Count unread
    $unreadCount = array_reduce($notifications, function ($carry, $item) {
        return $carry + ($item['is_read'] ? 0 : 1);
    }, 0);

    $response = [
        'success' => true,
        'message' => 'Notifications retrieved successfully',
        'unread_count' => $unreadCount,
        'data' => $notifications
    ];

    error_log("Sending successful response with " . count($notifications) . " notifications");
    echo json_encode($response);

} catch (PDOException $e) {
    error_log("Database Error in get_user_notifications.php: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    echo json_encode([
        'success' => false,
        'message' => 'Database connection error',
        'debug' => [
            'error' => $e->getMessage(),
            'code' => $e->getCode()
        ]
    ]);
} catch (Exception $e) {
    error_log("General Error in get_user_notifications.php: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    echo json_encode([
        'success' => false,
        'message' => 'Server error occurred',
        'debug' => [
            'error' => $e->getMessage()
        ]
    ]);
}

error_log("Script completed");