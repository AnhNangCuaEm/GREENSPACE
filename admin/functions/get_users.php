<?php
require_once __DIR__ . '/../../class/UserData.php';
require_once __DIR__ . '/../../functions/verify.php';

session_start();

// Verify admin access
$email = verifyToken();
if (!$email) {
    http_response_code(401);
    exit('Unauthorized');
}

$user = UserData::getUser($email);
if ($user->role !== 'admin') {
    http_response_code(403);
    exit('Forbidden');
}

// Get all users
$users = UserData::getAllUsers(); // You'll need to add this method to UserData class
header('Content-Type: application/json');
echo json_encode($users);