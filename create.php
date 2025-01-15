<?php
session_start(); // Start the session to use session variables

// Database connection parameters
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "thepagelibrary"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and escape special characters
    $password = $conn->real_escape_string($_POST['password']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    
    // Check for existing email or username
    $sql = "SELECT * FROM signup WHERE email = ?OR username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email or username already exists
        $_SESSION['error_message'] = "Error: Email or Username already exists.";
        header("Location: error_page.php"); // Redirect to your error page
        exit();
    } else {
        // Proceed with the insertion
        $insert_sql = "INSERT INTO signup (password, email, username) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sss", $password, $email, $username);

        if ($insert_stmt->execute()) {
            $_SESSION['success_message'] = "New user created successfully.";
            header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
            exit();
        } else {
            $_SESSION['error_message'] = "Error: " . $insert_stmt->error;
            header("Location: error_page.php"); // Redirect to your error page
            exit();
        }
    }

    $stmt->close();
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10;
            min-height: 100vh;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            background-color: #f4f4f4;
            flex-direction: column;
            padding: 20px;
            overflow-y: auto;
        }

        .form-container {
            border: 1px solid #ccc;
            padding: 40px;
            width: 100%;
            max-width: 900px;
            border-radius: 5px;
            text-align: left;
            background-color: rgb(179, 180, 182);
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
            background-color: #258dfc;
            color: #fff;
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
            background-color: #0d141a;
 }
    </style>
</head>

<body>
    <div class="form-container">
        <h3>Create New User</h3>
        <form action="" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" title="Please enter a valid password">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required>
                </div>
            </div>
            <div class="btn">
                <button type="submit" name="create" class="btn">Create</button>
            </div>
        </form>
    </div>
</body>
</html>