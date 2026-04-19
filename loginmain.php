<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "thepagelibrary"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = "";
$error_message = "";

// Handle User Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $pincode = trim($_POST['pincode']);
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = ($_POST['role'] === 'admin') ? 'admin' : 'user';

    if ($role === 'admin') {
        $approved_admins = ['pragyakathotia12@gmail.com', 'vaishnaviram@gmail.com'];
        if (!in_array($email, $approved_admins)) {
            die("❌ Admin registration is restricted.");
        }
    }

    // Insert user details into the database (including shipping details)
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, address, city, state, pincode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $username, $email, $hashed_password, $role, $address, $city, $state, $pincode);

    if ($stmt->execute()) {
        $success_message = "✅ Registration successful! <a href='#' onclick='showForm(\"user-login-form\")'>Login here</a>";
    } else {
        $error_message = "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle User & Admin Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: index.php");
                exit();
            } else {
                header("Location: homemain.php");
                exit();
            }
        } else {
            $error_message = "❌ Invalid password!";
        }
    } else {
        $error_message = "❌ User not found!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('vintage-paper.jpg') no-repeat center center/cover;
            font-family: 'Georgia', serif;
            color: #5a3e36;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: rgba(255, 239, 214, 0.9);
            padding: 40px;
            border: 3px solid #8b5e3b;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .button {
            background-color: #8b5e3b;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            font-weight: bold;
        }
        .button:hover {
            background-color: #5a3e36;
        }
        .form-container {
            display: none;
            margin-top: 20px;
        }
        .form-container.active {
            display: block;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #8b5e3b;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 2px solid #8b5e3b;
            border-radius: 5px;
            background-color: #f9e5c7;
            font-size: 14px;
            color: #5a3e36;
        }
        input::placeholder {
            color: #a0765a;
        }
        .message {
            font-weight: bold;
            margin-top: 10px;
        }
        .success {
            color: green;
        }
        .error {
            color: #b22222;
        }
    </style>
    <script>
        function showForm(formId) {
            document.querySelectorAll('.form-container').forEach(form => form.classList.remove('active'));
            document.getElementById(formId).classList.add('active');
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Welcome, Pookies 📖</h1>
        <div class="button-container">
            <button class="button" onclick="showForm('user-registration-form')">Register</button>
            <button class="button" onclick="showForm('user-login-form')">Login</button>
        </div>

        <div id="user-registration-form" class="form-container <?php echo isset($_POST['register']) ? 'active' : ''; ?>">
            <h2>Register</h2>
            <form method="POST">
                <input type="hidden" name="register" value="1">
                <label>Username:</label>
                <input type="text" name="username" required placeholder="Enter username">
                <label>Email:</label>
                <input type="email" name="email" required placeholder="Enter email">
                <label>Password:</label>
                <input type="password" name="password" required placeholder="Choose password">
                <label>Address:</label>
                <input type="text" name="address" required placeholder="Enter address">
                <label>City:</label>
                <input type="text" name="city" required placeholder="Enter city">
                <label>State:</label>
                <input type="text" name="state" required placeholder="Enter state">
                <label>Pincode:</label>
                <input type="text" name="pincode" required placeholder="Enter pincode">
                <label>Register as:</label>
                <select name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button class="button" type="submit">Register</button>
            </form>
            <?php if (!empty($success_message)) { echo "<p class='message success'>$success_message</p>"; } ?>
        </div>

        <div id="user-login-form" class="form-container <?php echo isset($_POST['login']) ? 'active' : ''; ?>">
            <h2>Login</h2>
            <form method="POST">
                <input type="hidden" name="login" value="1">
                <label>Username:</label>
                <input type="text" name="username" required placeholder="Enter username">
                <label>Password:</label>
                <input type="password" name="password" required placeholder="Enter password">
                <button class="button" type="submit">Login</button>
            </form>
            <?php if (!empty($error_message)) { echo "<p class='message error'>$error_message</p>"; } ?>
        </div>
    </div>
</body>
</html>
