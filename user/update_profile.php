<?php
include '../config/db_config.php'; // Adjust the path as per your file structure

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

// Check if form is submitted for profile details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if it's a profile picture update
    if (isset($_POST['cropped_image'])) {
        $data = $_POST['cropped_image'];

        // Decode the base64 encoded image
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);

        // Set a unique name for the image file
        $imageName = 'profile_' . $user_id . '.png';

        // Save the image file to the uploads directory
        file_put_contents('../uploads/' . $imageName, $data);

        // Update the user's profile picture in the database
        $query = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
        $query->execute([$imageName, $user_id]);

        // Redirect back to the profile page
        header('Location: profile.php');
        exit;
    }

    // Check if it's a profile details update
    if (isset($_POST['full_name']) && isset($_POST['email'])) {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $date_of_birth = $_POST['date_of_birth'];
        $address = $_POST['address'];

        // Update the user's profile details in the database
        $query = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone_number = ?, date_of_birth = ?, address = ? WHERE id = ?");
        $query->execute([$full_name, $email, $phone_number, $date_of_birth, $address, $user_id]);

        // Redirect back to the profile page
        header('Location: profile.php');
        exit;
    }
}

// Handle error if no valid form submission
die('Invalid form submission.');
?>