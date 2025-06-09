<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
    'isLoggedIn' => isset($_SESSION['id_nguoidung']),
    'message' => isset($_SESSION['id_nguoidung']) ? 'Logged in' : 'Not logged in'
]);

?>