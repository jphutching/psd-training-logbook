<?php
require 'includes/db_connect.php';
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uid = $_SESSION['user_id'];
    $loc = htmlspecialchars($_POST['location_name']);
    $cit = htmlspecialchars($_POST['location_city_state']);
    $typ = $_POST['location_type'];
    $foc = (int)$_POST['focus_level'];
    $notes = htmlspecialchars($_POST['handler_notes']);
    $skills = json_encode($_POST['skills'] ?? []);

.media-preview { 
    width: 60px; 
    height: 60px; 
    object-fit: cover; /* Prevents image stretching */
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

    $media = null;
    if (!empty($_FILES['training_media']['name'])) {
        if (!is_dir('uploads')) { mkdir('uploads', 0755, true); }
        $path = "uploads/" . time() . "_" . basename($_FILES['training_media']['name']);
        if (move_uploaded_file($_FILES['training_media']['tmp_name'], $path)) {
            $media = $path;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO daily_logs (user_id, location_name, location_city_state, location_type, focus_level, skills_practiced, handler_notes, media_url) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->execute([$uid, $loc, $cit, $typ, $foc, $skills, $notes, $media]);

    header("Location: view_logs.php");
    exit;
}
