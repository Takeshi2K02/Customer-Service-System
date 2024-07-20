<?php
$host = '127.0.0.1';
$db = 'customer_service';
$user = 'root'; // Update this to your database username
$pass = ''; // Update this to your database password
$charset = 'utf8mb4';

// Establish database connection using PDO
try {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>