<?php

require_once __DIR__ . '/../class/Database.php';
require_once __DIR__ . '/../class/UserData.php';
require_once __DIR__ . '/../class/ParkData.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    session_start();
    
    if ($_POST['action'] === 'updateLike' && isset($_POST['parkId'])) {
        $response = [
            'success' => false,
            'likeCount' => 0
        ];

        if (isset($_SESSION['email'])) {
            $updated = updateLike($_POST['parkId'], $_SESSION['email']);
            $newCount = countLikes($_POST['parkId']);
            
            $response = [
                'success' => $updated,
                'likeCount' => $newCount
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

function updateLike($parkId, $userEmail)
{
    //Add or delete like for a specific park
    $pdo = Database::getConnection();
    $query = "SELECT * FROM park_likes WHERE park_id = ? AND user_email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$parkId, $userEmail]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        //If already liked, delete like
        $query = "DELETE FROM park_likes WHERE park_id = ? AND user_email = ?";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$parkId, $userEmail]);
    } else {
        //If not liked, add like
        $query = "INSERT INTO park_likes (park_id, user_email) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$parkId, $userEmail]);
    }
}

function countLikes($parkId)
{
    //Count likes for a specific park
    $pdo = Database::getConnection();
    $query = "SELECT COUNT(*) FROM park_likes WHERE park_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$parkId]);
    return $stmt->fetchColumn();
}

function getLikedParks($userEmail)
{
    //Get list of parks liked by a user
    $pdo = Database::getConnection();
    $query = "SELECT park_id FROM park_likes WHERE user_email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userEmail]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}


function checkIfLiked($parkId, $userEmail) {
    $pdo = Database::getConnection();
    $query = "SELECT 1 FROM park_likes WHERE park_id = ? AND user_email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$parkId, $userEmail]);
    return (bool) $stmt->fetchColumn();
}
