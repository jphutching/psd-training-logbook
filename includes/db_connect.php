<?php
session_start();
$host = 'localhost';
$db   = 'psd_app_logs';
$user = 'root'; 
$pass = ''; // Default for KSWEB is usually empty

try {
     $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
     ]);
} catch (PDOException $e) {
     die("Connection failed: " . $e->getMessage());
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}
?>
