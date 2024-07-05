<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="content">
        <h1>Welcome to the User Dashboard, <?= htmlspecialchars($username) ?>!</h1>
        <p>This is the home page.</p>
    </div>
</body>
</html>