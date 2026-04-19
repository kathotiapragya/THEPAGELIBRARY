<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "thepagelibrary";

// Connect to database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['username'];

// Fetch user details
$sql = "SELECT * FROM users WHERE username='$user'";
$result = $conn->query($sql);
$user_data = $result->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    // Handle image upload
    $profile_picture = $user_data['profile_picture']; // Default to existing one
    if (!empty($_FILES["profile_picture"]["name"])) {
        $target_dir = "uploads/profile_pictures/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_name = time() . "_" . basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image file
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_types)) {
            die("Only JPG, JPEG, PNG, and GIF files are allowed.");
        }

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $target_file; // Update picture path
        }
    }

    // Update user information
    $sql = "UPDATE users SET email='$email', bio='$bio', profile_picture='$profile_picture' WHERE username='$user'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Profile updated successfully!'); window.location='profile.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f4e9;
        }
        .edit-form {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff8e1;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-update {
            background-color: rgb(196, 143, 97);
            color: white;
            border: none;
        }
    </style>
</head>
<body>

<div class="edit-form">
    <h2>Edit Profile</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="bio" class="form-label">Bio:</label>
            <textarea class="form-control" name="bio" rows="3"><?php echo htmlspecialchars($user_data['bio']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="profile_picture" class="form-label">Upload Profile Picture:</label>
            <input type="file" class="form-control" name="profile_picture" accept="image/*">
        </div>
        <button type="submit" class="btn btn-update">Update Profile</button>
    </form>
</div>

</body>
</html>
