<?php 
require 'includes/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $dog  = trim($_POST['dog_name']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Stress Test: Check if username exists
    $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $check->execute([$user]);
    
    if ($check->fetch()) {
        $error = "Username is already taken. Please try another.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, dog_name) VALUES (?, ?, ?)");
        $stmt->execute([$user, $pass, $dog]);
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
<body class="bg-light container p-5">
    <form method="POST" class="card p-4 mx-auto shadow-sm" style="max-width:400px;">
        <h3 class="text-center">New Driver Registration</h3>
        <hr>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Dog's Name</label>
            <input type="text" name="dog_name" class="form-control" placeholder="e.g. Otis" required>
        </div>
        <button class="btn btn-primary w-100 py-2">Create Account</button>
        <a href="login.php" class="d-block text-center mt-3 small text-decoration-none">Already have an account? Login</a>
    </form>
</body>
</html>
