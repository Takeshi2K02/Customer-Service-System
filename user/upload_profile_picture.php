<?php
session_start();
require '../config/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        $filename = basename($_FILES['profile_picture']['name']);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $sql = "UPDATE users SET profile_picture = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$filename, $user_id]);

            $_SESSION['profile_picture'] = $filename;
            header('Location: profile.php');
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>