<?php
session_start();
require_once __DIR__ . '/../../class/Database.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
   header('Content-Type: application/json');
   http_response_code(403);
   echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
   exit();
}
try {
   $conn = Database::getConnection();

   // Get average ratings and count for each category
   $query = "SELECT 
        COUNT(*) as total_feedbacks,
        AVG(uiux) as avg_uiux,
        AVG(content_rating) as avg_content,
        AVG(overall) as avg_overall,
        
        -- Calculate distribution for UIUX
        SUM(CASE WHEN uiux = 5 THEN 1 ELSE 0 END) as uiux_5,
        SUM(CASE WHEN uiux = 4 THEN 1 ELSE 0 END) as uiux_4,
        SUM(CASE WHEN uiux = 3 THEN 1 ELSE 0 END) as uiux_3,
        SUM(CASE WHEN uiux = 2 THEN 1 ELSE 0 END) as uiux_2,
        SUM(CASE WHEN uiux = 1 THEN 1 ELSE 0 END) as uiux_1,
        
        -- Calculate distribution for Content Rating
        SUM(CASE WHEN content_rating = 5 THEN 1 ELSE 0 END) as content_5,
        SUM(CASE WHEN content_rating = 4 THEN 1 ELSE 0 END) as content_4,
        SUM(CASE WHEN content_rating = 3 THEN 1 ELSE 0 END) as content_3,
        SUM(CASE WHEN content_rating = 2 THEN 1 ELSE 0 END) as content_2,
        SUM(CASE WHEN content_rating = 1 THEN 1 ELSE 0 END) as content_1,
        
        -- Calculate distribution for Overall
        SUM(CASE WHEN overall = 5 THEN 1 ELSE 0 END) as overall_5,
        SUM(CASE WHEN overall = 4 THEN 1 ELSE 0 END) as overall_4,
        SUM(CASE WHEN overall = 3 THEN 1 ELSE 0 END) as overall_3,
        SUM(CASE WHEN overall = 2 THEN 1 ELSE 0 END) as overall_2,
        SUM(CASE WHEN overall = 1 THEN 1 ELSE 0 END) as overall_1
    FROM feedback";

   $stmt = $conn->prepare($query);
   $stmt->execute();
   $stats = $stmt->fetch(PDO::FETCH_ASSOC);

   // Calculate percentages
   $total = $stats['total_feedbacks'];
   if ($total > 0) {
      $response = [
         'total_feedbacks' => $total,
         'averages' => [
            'uiux' => round($stats['avg_uiux'], 1),
            'content' => round($stats['avg_content'], 1),
            'overall' => round($stats['avg_overall'], 1)
         ],
         'distribution' => [
            'uiux' => [
               5 => round(($stats['uiux_5'] / $total) * 100, 1),
               4 => round(($stats['uiux_4'] / $total) * 100, 1),
               3 => round(($stats['uiux_3'] / $total) * 100, 1),
               2 => round(($stats['uiux_2'] / $total) * 100, 1),
               1 => round(($stats['uiux_1'] / $total) * 100, 1)
            ],
            'content' => [
               5 => round(($stats['content_5'] / $total) * 100, 1),
               4 => round(($stats['content_4'] / $total) * 100, 1),
               3 => round(($stats['content_3'] / $total) * 100, 1),
               2 => round(($stats['content_2'] / $total) * 100, 1),
               1 => round(($stats['content_1'] / $total) * 100, 1)
            ],
            'overall' => [
               5 => round(($stats['overall_5'] / $total) * 100, 1),
               4 => round(($stats['overall_4'] / $total) * 100, 1),
               3 => round(($stats['overall_3'] / $total) * 100, 1),
               2 => round(($stats['overall_2'] / $total) * 100, 1),
               1 => round(($stats['overall_1'] / $total) * 100, 1)
            ]
         ],
         'raw_counts' => [
            'uiux' => [
               5 => $stats['uiux_5'],
               4 => $stats['uiux_4'],
               3 => $stats['uiux_3'],
               2 => $stats['uiux_2'],
               1 => $stats['uiux_1']
            ],
            'content' => [
               5 => $stats['content_5'],
               4 => $stats['content_4'],
               3 => $stats['content_3'],
               2 => $stats['content_2'],
               1 => $stats['content_1']
            ],
            'overall' => [
               5 => $stats['overall_5'],
               4 => $stats['overall_4'],
               3 => $stats['overall_3'],
               2 => $stats['overall_2'],
               1 => $stats['overall_1']
            ]
         ]
      ];
   } else {
      $response = [
         'total_feedbacks' => 0,
         'averages' => ['uiux' => 0, 'content' => 0, 'overall' => 0],
         'distribution' => [
            'uiux' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
            'content' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
            'overall' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]
         ],
         'raw_counts' => [
            'uiux' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
            'content' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0],
            'overall' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0]
         ]
      ];
   }

   header('Content-Type: application/json');
   echo json_encode($response);
} catch (PDOException $e) {
   error_log("Database error in get_feedback_stats.php: " . $e->getMessage());
   header('Content-Type: application/json');
   http_response_code(500);
   echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
