<?php 
require 'includes/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $dog  = trim($_POST['dog_name']);
    $breed = trim($_POST['breed']);
    $chip = trim($_POST['chip_number']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $check->execute([$user]);
    
    if ($check->fetch()) {
        $error = "Username taken.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, dog_name, breed, chip_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user, $pass, $dog, $breed, $chip]);
        header("Location: login.php?msg=registered");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <form method="POST" class="card p-4 mx-auto shadow" style="max-width:400px;">
        <h3 class="text-center">🐾 Handler Setup</h3>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <h6>Dog Profile</h6>
        <input type="text" name="dog_name" class="form-control mb-2" placeholder="Dog Name" required>
        <input type="text" name="breed" class="form-control mb-2" placeholder="Breed">
        <input type="text" name="chip_number" class="form-control mb-3" placeholder="Microchip ID">
        <button class="btn btn-primary w-100">Initialize App</button>
    </form>
</body>
</html>
