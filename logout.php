<?php
require_once __DIR__ . '/functions/verify.php';

session_start();
session_unset();
session_destroy();
logout();
header('Location: login.php');
exit();
