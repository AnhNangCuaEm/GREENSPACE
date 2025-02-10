<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../class/UserData.php';

checkAdmin();

$users = UserData::getAllUsers(); // You'll need to add this method to UserData class
header('Content-Type: application/json');
echo json_encode($users);
