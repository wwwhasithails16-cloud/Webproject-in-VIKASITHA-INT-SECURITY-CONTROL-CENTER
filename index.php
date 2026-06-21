<?php
session_start();
require_once __DIR__ . '/init.php';

if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $usersData = readJsonFile($USERS_FILE, ['users' => []]);
    foreach ($usersData['users'] as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password_hash'])) {
            $_SESSION['username'] = $username;
            header('Location: dashboard.php');
            exit();
        }
    }

    $error = 'Invalid username or password';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security System Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-body">
    <div class="login-wrapper">
        <div class="login-card glass-card">
            <div class="brand-badge">Smart Security System</div>
            <h1>Welcome Back</h1>
            <p class="muted">Login to monitor PIR motion security system.</p>

            <?php if ($error): ?>
                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Enter username">

                <label>Password</label>
                <input type="password" name="password" required placeholder="Enter password">

                <button type="submit" class="primary-btn full-btn">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
