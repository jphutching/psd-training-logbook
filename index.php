<?php
require_once 'includes/db_connect.php';
checkLogin();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light pb-5">
    <div class="bg-primary text-white p-4 text-center mb-4">
        <h2>🐾 <?= htmlspecialchars($_SESSION['dog_name']) ?></h2>
        <small>Service Dog Management System</small>
    </div>
    <div class="container">
        <div class="row g-3">
            <div class="col-6"><a href="log_entry.php" class="btn btn-white shadow-sm w-100 py-4 border">📝 Log Training</a></div>
            <div class="col-6"><a href="view_logs.php" class="btn btn-white shadow-sm w-100 py-4 border">📋 History</a></div>
            <div class="col-6"><a href="settings.php" class="btn btn-white shadow-sm w-100 py-4 border">⚙️ Settings</a></div>
            <div class="col-6"><a href="profile.php?id=<?= $_SESSION['user_id'] ?>" class="btn btn-white shadow-sm w-100 py-4 border">🐶 Digital ID</a></div>
        </div>
    </div>
</body>
</html>
