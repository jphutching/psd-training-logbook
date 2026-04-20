<?php
require_once 'includes/db_connect.php';
checkLogin();

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT dog_name FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$logStmt = $pdo->prepare("SELECT COUNT(id) as total FROM daily_logs WHERE user_id = ?");
$logStmt->execute([$user_id]);
$logCount = $logStmt->fetch()['total'];
$progress = min(($logCount / 100) * 100, 100);

$public_url = "http://" . $_SERVER['HTTP_HOST'] . "/profile.php?id=" . $user_id;
$qr_api_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($public_url);
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4 bg-light">
    <h2>⚙️ Settings</h2>
    <div class="card p-4 mb-4 shadow-sm">
        <h5>Mastery: <?= htmlspecialchars($user['dog_name']) ?></h5>
        <div class="progress mt-2" style="height:30px;">
            <div class="progress-bar bg-success" style="width: <?= $progress ?>%;"><?= round($progress) ?>%</div>
        </div>
    </div>
    <div class="card p-4 text-center shadow-sm">
        <h4>Digital ID</h4>
        <img src="<?= $qr_api_url ?>" class="img-fluid mx-auto my-3" style="width:200px;">
        <div class="d-grid gap-2">
            <button onclick="window.print()" class="btn btn-primary">Print QR</button>
            <a href="view_logs.php" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</body>
</html>
