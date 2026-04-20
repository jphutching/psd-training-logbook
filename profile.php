<?php
require_once 'includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { 
    die("Error: Profile link is incomplete."); 
}

$dog_id = (int)$_GET['id'];

// Fetch dog info and count total training sessions
$stmt = $pdo->prepare("
    SELECT u.dog_name, COUNT(l.id) as total_logs, MAX(l.log_date) as last_trained 
    FROM users u 
    LEFT JOIN daily_logs l ON u.id = l.user_id 
    WHERE u.id = ?
    GROUP BY u.id
");
$stmt->execute([$dog_id]);
$data = $stmt->fetch();

if (!$data) { 
    die("Profile not found."); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?= htmlspecialchars($data['dog_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center p-4">
    <div class="card shadow-lg mx-auto mt-4" style="max-width: 450px; border-top: 10px solid #0d6efd;">
        <div class="card-body">
            <h1 class="display-6">🐾 Service Dog Profile</h1>
            <p class="text-muted">Digital Proof of Training</p>
            <hr>
            
            <h2 class="mb-1"><?= htmlspecialchars($data['dog_name']) ?></h2>
            <p class="badge bg-success mb-4" style="font-size: 1rem;">Training Status: Active</p>
            
            <div class="row text-center border-top pt-4">
                <div class="col-6 border-end">
                    <h5 class="mb-0"><?= $data['total_logs'] ?></h5>
                    <small class="text-muted">Logs Recorded</small>
                </div>
                <div class="col-6">
                    <h5 class="mb-0"><?= $data['last_trained'] ? date('M d, Y', strtotime($data['last_trained'])) : '---' ?></h5>
                    <small class="text-muted">Last Session</small>
                </div>
            </div>
            
            <div class="alert alert-info mt-4 small text-start">
                <strong>Public Note:</strong> This dog is currently participating in a structured training program for Public Access and Task Work.
            </div>
        </div>
    </div>
    <div class="mt-4 text-muted">
        <small>Powered by the Digital Training Logbook</small>
    </div>
</body>
</html>
