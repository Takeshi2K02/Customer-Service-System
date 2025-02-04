<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'customer_service'); // Update with your DB credentials
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT profile_picture FROM users WHERE id = '$user_id'");
$row = $result->fetch_assoc();

if ($row) {
    $_SESSION['profile_picture'] = $row['profile_picture'];
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'default.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav>
        <ul class="nav-left">
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="faq.php">FAQ</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="about_us.php">About Us</a></li>
        </ul>
        <ul class="nav-right">
            <li>
                <div class="dropdown">
                    <!-- Display profile picture -->
                    <img src="../uploads/<?= htmlspecialchars($profile_picture) ?>" alt="Profile Picture" class="profile-pic">
                    <span class="dropdown-toggle"><?= htmlspecialchars($username) ?> &#9662;</span>
                    <div class="dropdown-menu">
                        <a href="profile.php">Profile</a>
                        <a href="settings.php">Settings</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
</body>
</html>