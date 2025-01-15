<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "thepagelibrary"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data if username is provided
$userData = null;
if (isset($_GET['username'])) {
    $username_to_edit = $conn->real_escape_string($_GET['username']);
    $sql = "SELECT email, username FROM signup WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username_to_edit);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission for updating user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $conn->real_escape_string($_POST['new_username']);
    $new_email = $conn->real_escape_string($_POST['email']);
    $current_username = $conn->real_escape_string($_POST['current_username']); // Get the current username

    // Validate inputs
    if (empty($new_username) || strlen($new_username) < 3) {
        $_SESSION['error_message'] = "Username must be at least 3 characters long.";
        header("Location: admin_dashboard.php");
        exit();
    }

    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
        header("Location: admin_dashboard.php");
        exit();
    }

    // Check for unique username and email
    $stmt = $conn->prepare("SELECT * FROM signup WHERE (username = ? OR email = ?) AND username != ?");
    $stmt->bind_param("ssi", $new_username, $new_email, $current_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Username or email already exists.";
        header("Location: admin_dashboard.php");
        exit();
    }

    // Update user data
    $update_sql = "UPDATE signup SET email=?, username=? WHERE username=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sss", $new_email, $new_username, $current_username);

    if ($update_stmt->execute()) {
        $_SESSION['success_message'] = "User  updated successfully.";
        header("Location: admin_dashboard.php"); // Redirect back to the dashboard
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $update_stmt->error;
    }
    $update_stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        /* Include your existing styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 10;
            min-height: 100vh;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            background-color: #E5AA70;
            flex-direction: column;
            padding: 20px;
            overflow-y: auto;
            color: rgb(89, 37, 11);
        }

        .form-container {
            border: 1px solid #ccc;
            padding: 40px;
            width: 100%;
            max-width: 900px;
            border-radius: 5px;
            text-align: left;
            background-color: #FFE4C4;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            margin-right: 10px;
        }

        .form-group:last-child {
            margin-right: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            font-family: inherit;
        }

        .form-group input[type="text"],
        .form-group input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-family: inherit;
            box-sizing: border-box;
        }

        .btn {
            background-color:rgb(248, 180, 97);
            color: rgb(89, 37, 11);

            padding: 3.5px 20px;
            border: none;
            border-radius: 3px;
            text-decoration: none;
            display: block;
            margin: 10px auto;
            width: fit-content;
            cursor: pointer;
        }

        .btn:hover {
            background-color:rgb(54, 27, 8);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h3>Edit User</h3>
        <?php if ($userData): ?>
            <form action="" method="POST">
                <input type="hidden" name="current_username" value="<?php echo htmlspecialchars($userData['username']); ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label for="new_username">New Username:</label>
                        <input type="text" name="new_username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                    </div>
                </div>
                <div class="btn">
                    <button type="submit" name="update" class="btn">Update</button>
                </div>
            </form>
        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>