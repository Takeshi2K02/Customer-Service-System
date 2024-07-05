<?php include 'header.php'; ?>
<div class="content profile">
    <h1>Profile</h1>
    <form action="upload_profile_picture.php" method="post" enctype="multipart/form-data">
        <label for="profile_picture">Upload Profile Picture:</label>
        <input type="file" name="profile_picture" id="profile_picture" required>
        <button type="submit">Upload</button>
    </form>
</div>
</body>
</html>