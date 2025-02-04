<?php
session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}
require_once __DIR__ . '/../../class/Database.php';

try {
    $conn = Database::getConnection();
    $period = isset($_GET['period']) ? $_GET['period'] : '7days';

    // Debug output
    error_log("Period: " . $period);

    switch ($period) {
        case '24hours':
            $timeSQL = "DATE_SUB(NOW(), INTERVAL 24 HOUR)";
            $groupBy = "HOUR(visit_time)";
            $dateFormat = "%H:00";
            break;
        case '7days':
            $timeSQL = "DATE_SUB(NOW(), INTERVAL 7 DAY)";
            $groupBy = "DATE(visit_time)";
            $dateFormat = "%Y-%m-%d";
            break;
        case '30days':
            $timeSQL = "DATE_SUB(NOW(), INTERVAL 30 DAY)";
            $groupBy = "DATE(visit_time)";
            $dateFormat = "%Y-%m-%d";
            break;
        default:
            $timeSQL = "DATE_SUB(NOW(), INTERVAL 7 DAY)";
            $groupBy = "DATE(visit_time)";
            $dateFormat = "%Y-%m-%d";
    }

    // Debug: Print the query
    $chartQuery = "SELECT 
        DATE_FORMAT(visit_time, :dateFormat) as time_period,
        COUNT(*) as visit_count,
        COUNT(DISTINCT visitor_ip) as unique_visitors
    FROM page_visits 
    WHERE visit_time >= {$timeSQL}
    GROUP BY time_period
    ORDER BY MIN(visit_time) ASC";

    error_log("Chart Query: " . $chartQuery);

    $stmt = $conn->prepare($chartQuery);
    $stmt->bindParam(':dateFormat', $dateFormat, PDO::PARAM_STR);

    // Debug: Print bound parameters
    error_log("Date Format: " . $dateFormat);

    $stmt->execute();
    $chartData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug: Print result
    error_log("Chart Data: " . print_r($chartData, true));

    // Get summary statistics
    $statsQuery = "SELECT 
        COUNT(*) as total_visits,
        COUNT(DISTINCT visitor_ip) as unique_visitors,
        COUNT(DISTINCT user_email) as logged_in_users,
        COUNT(CASE WHEN device_type = 'mobile' THEN 1 END) as mobile_visits,
        COUNT(CASE WHEN device_type = 'desktop' THEN 1 END) as desktop_visits,
        COUNT(CASE WHEN device_type = 'tablet' THEN 1 END) as tablet_visits
    FROM page_visits 
    WHERE visit_time >= {$timeSQL}";

    $stmt = $conn->prepare($statsQuery);
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get page breakdown
    $pageQuery = "SELECT 
        page_name,
        COUNT(*) as visit_count
    FROM page_visits 
    WHERE visit_time >= {$timeSQL}
    GROUP BY page_name
    ORDER BY visit_count DESC";

    $stmt = $conn->prepare($pageQuery);
    $stmt->execute();
    $pageStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get top visitors
    $visitorQuery = "SELECT 
        COALESCE(user_email, 'Anonymous') as visitor,
        COUNT(*) as visit_count
    FROM page_visits 
    WHERE visit_time >= {$timeSQL}
    GROUP BY user_email
    ORDER BY visit_count DESC
    LIMIT 5";

    $stmt = $conn->prepare($visitorQuery);
    $stmt->execute();
    $topVisitors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ensure default values if no data
    if (empty($chartData)) {
        $chartData = [[
            'time_period' => date('Y-m-d'),
            'visit_count' => 0,
            'unique_visitors' => 0
        ]];
    }

    if (!$stats) {
        $stats = [
            'total_visits' => 0,
            'unique_visitors' => 0,
            'logged_in_users' => 0,
            'mobile_visits' => 0,
            'desktop_visits' => 0,
            'tablet_visits' => 0
        ];
    }

    $response = [
        'chartData' => $chartData,
        'summary' => $stats,
        'pageBreakdown' => $pageStats ?? [],
        'topVisitors' => $topVisitors ?? []
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    error_log("Database error in get_traffic_data.php: " . $e->getMessage());
    error_log("SQL State: " . $e->getCode());
    error_log("Stack trace: " . $e->getTraceAsString());

    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error: ' . $e->getMessage(),
        'sql_state' => $e->getCode(),
        'chartData' => [[
            'time_period' => date('Y-m-d'),
            'visit_count' => 0,
            'unique_visitors' => 0
        ]],
        'summary' => [
            'total_visits' => 0,
            'unique_visitors' => 0,
            'logged_in_users' => 0,
            'mobile_visits' => 0,
            'desktop_visits' => 0,
            'tablet_visits' => 0
        ],
        'pageBreakdown' => [],
        'topVisitors' => []
    ]);
}
