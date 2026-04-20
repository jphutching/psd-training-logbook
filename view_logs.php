<?php 
require_once 'includes/db_connect.php'; 
checkLogin();

$stmt = $pdo->prepare("SELECT * FROM daily_logs WHERE user_id = ? ORDER BY log_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$logs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="theme-color" content="#0d6efd">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print { .no-print { display: none !important; } }
        .media-preview { max-width: 80px; border-radius: 5px; }
    </style>
</head>
<body class="container-fluid mt-4 bg-light">
    <div class="d-flex justify-content-between mb-4 no-print">
        <h2> Training Records: <?= htmlspecialchars($_SESSION['dog_name']) ?></h2>
        <div>
            <a href="index.php" class="btn btn-primary">+ New</a>
            <a href="settings.php" class="btn btn-secondary">Settings</a>
            <button onclick="window.print()" class="btn btn-success">Print</button>
        </div>
    </div>
    <div class="table-responsive card shadow-sm p-3">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Skills/Focus</th>
                    <th>Notes</th>
                    <th>Media</th>
                    <th class="no-print">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): $skills = json_decode($log['skills_practiced'], true) ?: []; ?>
                <tr>
                    <td><?= date('M d, H:i', strtotime($log['log_date'])) ?></td>
                    <td><strong><?= htmlspecialchars($log['location_name']) ?></strong><br><small><?= htmlspecialchars($log['location_city_state']) ?></small></td>
                    <td>
                        <?php foreach ($skills as $s): ?> <span class="badge bg-info text-dark"><?= htmlspecialchars($s) ?></span> <?php endforeach; ?>
                        <br><small>Focus: <?= $log['focus_level'] ?>/5</small>
                    </td>
                    <td><small><?= nl2br(htmlspecialchars($log['handler_notes'])) ?></small></td>
                    <td>
                        <?php if ($log['media_url']): ?>
                            <img src="<?= $log['media_url'] ?>" class="media-preview">
                        <?php endif; ?>
                    </td>
                    <td class="no-print"><a href="edit_log.php?id=<?= $log['id'] ?>" class="btn btn-sm btn-warning">Edit</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
