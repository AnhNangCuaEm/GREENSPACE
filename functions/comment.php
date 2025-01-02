<?php 

require_once __DIR__ . '/../class/Database.php';

/**
 * Lưu comment mới vào database
 */
function saveComment($parkId, $userEmail, $nickname, $content) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $sql = "INSERT INTO comments (park_id, user_email, nickname, content) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$parkId, $userEmail, $nickname, $content]);
}

function deleteComment($commentId) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $sql = "DELETE FROM comments WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$commentId]);
}

//function to check if the user is the owner of the comment or not and return true or false
function isOwner($commentId, $userEmail) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $sql = "SELECT * FROM comments WHERE id = ? AND user_email = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$commentId, $userEmail]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Lấy tất cả comment theo park_id
 */
function getCommentsByParkId($parkId) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $sql = "SELECT c.*, c.nickname as user_name 
            FROM comments c
            WHERE park_id = ?
            ORDER BY created_at DESC LIMIT 2";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$parkId]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllCommentsByParkId($parkId) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $sql = "SELECT c.*, c.nickname as user_name 
            FROM comments c
            WHERE park_id = ?
            ORDER BY created_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$parkId]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $parkId = $_POST['parkId'] ?? null;
    $email = $_POST['email'] ?? null;
    $nickname = $_POST['nickname'] ?? '無名さん';
    $content = trim($_POST['comment'] ?? null);

    if (!$parkId || !$email || !$content) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    try {
        $result = saveComment($parkId, $email, $nickname, $content);
        echo json_encode(['success' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    header('Content-Type: application/json');
    
    // Parse DELETE request data
    parse_str(file_get_contents("php://input"), $_DELETE);
    $commentId = $_DELETE['commentId'] ?? null;
    $userEmail = $_DELETE['email'] ?? null;

    if (!$commentId || !$userEmail) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    // Check if user owns the comment
    if (!isOwner($commentId, $userEmail)) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

    try {
        $result = deleteComment($commentId);
        echo json_encode(['success' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

