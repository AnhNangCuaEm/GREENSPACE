<?php
require_once __DIR__ . '/functions/verify.php';

session_start(); // Start the session
logout(); // Call the logout function to delete the cookie and redirect
header('Location: login.php'); // Redirect to login.php
exit();
