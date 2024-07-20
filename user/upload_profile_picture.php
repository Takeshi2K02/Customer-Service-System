<?php
include '../config/db_config.php'; // Adjust the path as per your file structure

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

// Check if an image file is provided
if (isset($_POST['cropped_image'])) {
    $data = $_POST['cropped_image'];

    // Decode the base64 encoded image
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);

    // Set a unique name for the image file
    $imageName = 'profile_' . $user_id . '.png';

    // Save the image file to the uploads directory
    file_put_contents('../uploads/' . $imageName, $data);

    // Update the user's profile picture in the database
    $query = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
    $query->execute([$imageName, $user_id]);

    echo 'Success';
} else {
    // Handle error if no image is provided
    die('No image provided.');
}
?>