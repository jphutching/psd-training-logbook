<?php 
require 'includes/db_connect.php'; 

// Stress Test: Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['dog_name'] = $user['dog_name'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
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
        <h3 class="text-center">Driver Login</h3>
        <hr>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if(isset($_GET['msg'])) echo "<div class='alert alert-success small text-center px-0'>Registration successful! Please login.</div>"; ?>

        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button class="btn btn-success w-100 py-2">Login</button>
        <a href="register.php" class="d-block text-center mt-3 small text-decoration-none">New Driver? Register</a>
    </form>
</body>
</html>
