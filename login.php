<?php
session_start();

$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "thepagelibrary"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dummy credentials for admins
$admin_credentials = 
[
    ["username" => "pragya", "password" => "kpragya1"],
    ["username" => "vaishnavi", "password" => "vaivai"]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    // Initialize variables to track login status
    $email_exists = false;
    $is_valid = false;

    // Check if the credentials are correct for dummy admins
    foreach ($admin_credentials as $admin) {
        if ($email === $admin['username']) {
            $email_exists = true; // Email exists
            if ($password === $admin['password']) {
                $is_valid = true; // Password is correct
            }
            break; // No need to check further once we find the email
        }
    }

    if ($is_valid) {
        // Redirect to admin dashboard if credentials are valid
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } elseif ($email_exists) {
        // Redirect to error page if email exists but password is incorrect
        header("Location: error_page.php");
        exit();
    } else {
        // Check the database for user credentials
        $sql = "SELECT passwords, role FROM signup WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // Email exists in the database, now check the password
            $stmt->bind_result($hashed_password, $role);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, start a new session
                $_SESSION['admin_logged_in'] = true;

                // Redirect based on user role
                if ($role === 'admin') {
                    header("Location: admin_dashboard.php"); // Redirect to admin dashboard
                } else {
                    header("Location: homemain.html"); // Redirect to homepage for regular users
                }
                exit();
            } else {
                // Password is incorrect
                header("Location: error_page.php"); // Redirect to error page
                exit();
            }
        } else {
            // Email does not exist in the database
            header("Location: signup.php"); // Redirect to signup page
            exit();
        }

        $stmt->close();
    }
}

$conn->close();
?>