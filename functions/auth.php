<?php
function checkAuth()
{
   if (!isset($_SESSION['email'])) {
      header('Location: /index.php');
      exit();
   }
   return $_SESSION['email'];
}

function checkAdmin()
{
   checkAuth();

   if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
      if (isApiRequest()) {
         header('Content-Type: application/json');
         http_response_code(403);
         echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
      } else {
         header('Location: /index.php');
      }
      exit();
   }
   return true;
}

function isApiRequest()
{
   return (
      !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
   ) ||
      (strpos($_SERVER['REQUEST_URI'], '/functions/') !== false);
}
