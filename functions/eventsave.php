<?php

require_once __DIR__ . '/../class/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    session_start();
    
    if ($_POST['action'] === 'updateSave' && isset($_POST['eventId'])) {
        $response = [
            'success' => false,
            'isSaved' => false
        ];

        if (isset($_SESSION['email'])) {
            $updated = updateSave($_POST['eventId'], $_SESSION['email']);
            
            $response = [
                'success' => $updated,
                'isSaved' => checkIfSaved($_POST['eventId'], $_SESSION['email'])
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

function updateSave($eventId, $userEmail) {
    $pdo = Database::getConnection();
    $query = "SELECT * FROM event_saved WHERE event_id = ? AND user_email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$eventId, $userEmail]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Nếu đã save thì xóa save
        $query = "DELETE FROM event_saved WHERE event_id = ? AND user_email = ?";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$eventId, $userEmail]);
    } else {
        // Nếu chưa save thì thêm save
        $query = "INSERT INTO event_saved (event_id, user_email) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$eventId, $userEmail]);
    }
}

function checkIfSaved($eventId, $userEmail) {
    $pdo = Database::getConnection();
    $query = "SELECT 1 FROM event_saved WHERE event_id = ? AND user_email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$eventId, $userEmail]);
    return (bool) $stmt->fetchColumn();
}

function getSavedEvents($userEmail) {
    // Get list of saved events for a user
    $pdo = Database::getConnection();
    $query = "SELECT event_id FROM event_saved WHERE user_email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userEmail]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}