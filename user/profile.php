<?php
include '../config/db_config.php'; // Adjust the path as per your file structure

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

// Query to fetch user details from the database
$query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Check if user exists
if (!$user) {
    die("User not found.");
}

// Initialize variables with user data, escaping HTML for security
$full_name = htmlspecialchars($user['name']); // Change 'full_name' to 'name'
$email = htmlspecialchars($user['email']);
$phone_number = isset($user['phone_number']) ? htmlspecialchars($user['phone_number']) : '';
$date_of_birth = isset($user['date_of_birth']) ? htmlspecialchars($user['date_of_birth']) : '';
$address = isset($user['address']) ? htmlspecialchars($user['address']) : '';
$profile_picture = htmlspecialchars($user['profile_picture']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="profile-container">
    <h1>User Profile</h1>

    <div class="profile-picture">
        <div class="crop-wrapper">
            <img id="image" src="../uploads/<?= $profile_picture ?>" alt="Profile Picture" class="profile-pic">
        </div>
        <form id="profilePictureForm" enctype="multipart/form-data">
            <label for="profile_picture" class="file-label">Edit Profile Picture</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
            <button type="button" id="uploadButton" style="display:none;">Upload</button>
            <input type="hidden" id="cropped_image" name="cropped_image">
        </form>
    </div>
    <form id="profileForm" action="update_profile.php" method="post" class="profile-form">
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" class="form-control" value="<?= $full_name ?>" disabled>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= $email ?>" disabled>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?= $phone_number ?>" disabled>
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="<?= $date_of_birth ?>" disabled>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" class="form-control" value="<?= $address ?>" disabled>
        </div>
        <button type="button" id="editButton">Edit</button>
        <button type="submit" id="saveButton" style="display:none;">Save Changes</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.getElementById('profile_picture').addEventListener('change', function (e) {
    if (e.target.files && e.target.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var image = document.getElementById('image');
            image.src = e.target.result;

            // Ensure image is fully loaded before initializing Cropper
            image.onload = function () {
                var cropper = new Cropper(image, {
                    aspectRatio: 1, // Change aspect ratio to 1 for square cropping
                    viewMode: 1,
                    autoCropArea: 1,
                    crop: function (event) {
                        var canvas = cropper.getCroppedCanvas({
                            width: 300, // Adjust the width to maintain a square crop
                            height: 300, // Adjust the height to maintain a square crop
                        });
                        // Set cropped image data to hidden input field
                        document.getElementById('cropped_image').value = canvas.toDataURL();
                    },
                });

                // Show upload button after selecting a file
                document.getElementById('uploadButton').style.display = 'inline-block';
            };
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

document.getElementById('uploadButton').addEventListener('click', function () {
    var formData = new FormData();
    formData.append('cropped_image', document.getElementById('cropped_image').value);
    
    $.ajax({
        url: 'upload_profile_picture.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            location.reload(); // Reload the current page
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
});

document.getElementById('editButton').addEventListener('click', function () {
    document.querySelectorAll('#profileForm input, #profileForm textarea').forEach(function (input) {
        input.disabled = false;
    });
    document.getElementById('saveButton').style.display = 'inline-block';
    document.getElementById('editButton').style.display = 'none';
});
</script>

</body>
</html>