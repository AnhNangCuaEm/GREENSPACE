<?php
require_once __DIR__ . '/../class/Database.php';

function getClientIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    
    //If multiple IPs, get the first one
    if (strpos($ipaddress, ',') !== false) {
        $ips = explode(',', $ipaddress);
        $ipaddress = trim($ips[0]);
    }
    
    return $ipaddress;
}

function trackPageVisit($pageName) {
    try {
        $conn = Database::getConnection();
        
        // Get visitor IP using new function
        $visitorIP = getClientIP();
        
        // Get user email if logged in
        $userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : null;
        
        // Get device and browser info
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $deviceType = 'desktop';
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $userAgent)) {
            $deviceType = 'mobile';
        } elseif (preg_match('/tablet|ipad/i', $userAgent)) {
            $deviceType = 'tablet';
        }
        
        // Get browser info
        $browser = 'Unknown';
        if (preg_match('/MSIE/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        }
        
        // Insert visit record using PDO
        $stmt = $conn->prepare("INSERT INTO page_visits (page_name, visitor_ip, user_email, device_type, browser) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$pageName, $visitorIP, $userEmail, $deviceType, $browser]);
        
    } catch (PDOException $e) {
        // Log error silently - don't want to break the page if tracking fails
        error_log("Track visit error: " . $e->getMessage());
    }
}