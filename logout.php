<?php
require_once __DIR__ . '/functions/verify.php';

session_start();
logout();
header('Location: login.php');
exit();
