<?php
session_start();
require '../config/db_config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['name'];  // Store the user's name in the session
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header('Location: ../admin/dashboard.php');
        } else {
            header('Location: ../user/dashboard.php');
        }
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>