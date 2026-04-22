<?php
require_once 'includes/db_connect.php';
$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT dog_name, breed, chip_number FROM users WHERE id = ?");
$stmt->execute([$id]);
$dog = $stmt->fetch();
if (!$dog) die("Profile not found.");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4 text-center">
    <div class="card shadow-lg p-4 mx-auto" style="max-width:400px; border-top: 10px solid #0d6efd;">
        <h1 class="mb-0"><?= htmlspecialchars($dog['dog_name']) ?></h1>
        <p class="text-muted"><?= htmlspecialchars($dog['breed']) ?></p>
        <hr>
        <p><strong>Microchip:</strong> <?= htmlspecialchars($dog['chip_number'] ?: 'Not Listed') ?></p>
        <?php if($dog['chip_number']): ?>
            <div class="small">
                <a href="https://www.foundanimals.org/microchip-registry/" target="_blank">24PetWatch</a> | 
                <a href="https://www.akcreunite.org/" target="_blank">AKC Reunite</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
