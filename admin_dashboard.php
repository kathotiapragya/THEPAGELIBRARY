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

// Handle form submissions for creating, updating, and deleting data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        // Create new record
        $email = $conn->real_escape_string($_POST['email']);
        $username = $conn->real_escape_string($_POST['username']);
        
        // Check for existing email or username
        $sql = "SELECT * FROM signup WHERE email = ?  OR username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $phone_number, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error_message'] = "Error: Email, Phone Number, or Username already exists.";
            header("Location: error_page.php");
            exit();
        } else {
            $insert_sql = "INSERT INTO signup ( email, username) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ss",$email, $username);

            if ($insert_stmt->execute()) {
                $_SESSION['success_message'] = "New record created successfully.";
            } else {
                $_SESSION['error_message'] = "Error: " . $insert_stmt->error;
            }
        }

        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Update existing record
        $current_username = $conn->real_escape_string($_POST['current_username']);
        $new_username = $conn->real_escape_string($_POST['new_username']);
        $email = $conn->real_escape_string($_POST['email']);
    
        // Check if the new username already exists
        $check_sql = "SELECT * FROM signup WHERE username = ? AND username != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ss", $new_username, $current_username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
    
        if ($check_result->num_rows > 0) {
            $_SESSION['error_message'] = "Error: Username already exists.";
        } else {
            $sql = "UPDATE signup SET username=?, email=? WHERE username=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $new_username, $email, $current_username);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "User  updated successfully.";
            } else {
                $_SESSION['error_message'] = "Error: " . $stmt->error;
            }
        }
        $check_stmt->close();
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        // Delete record
        $username_to_delete = $conn->real_escape_string($_POST['username_to_delete']);
        $sql = "DELETE FROM signup WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username_to_delete);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "User  deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
// Fetch data to display (excluding the name column)
$sql = "SELECT email, username FROM signup"; 
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
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
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        h1 {
            text-align: center;
            width: 100%;
            margin-bottom: 20px;
        }
        .table-container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            background-color: rgb(172, 151, 119);
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-height: 400px;
            overflow-y: auto;
        }

        .form-container {
            border: 1px solid #ccc;
            padding: 60px;
            width: 100%;
            max-width: 900px;
            border-radius: 10px;
            text-align: left;
            background-color: #FFE4C4;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
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
        }

        .form-group input[type="text"],
        .form-group input[type="email"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-group input[type="submit"] {
            margin-top: 10px;
            padding: 14px;
            width: 100%;
            font-size: 18px;
            font-weight: bold;
            background-color: rgb(233, 206, 155);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-group input[type="submit"]:hover {
            background-color:rgb(233, 206, 155);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            background-color: rgb(179, 108, 8);
            color: #fff;
            padding: 2px 10px; /* Reduced padding for smaller buttons */
            border: none;
            border-radius: 3px;
            text-decoration: none;
            display: inline-block; /* Change to inline-block for better sizing */
            margin: 5px auto; /* Adjust margin if needed */
            width: fit-content; /* Keep this to fit the content */
            cursor: pointer;
            font-size: 14px; /* Adjust font size for smaller text */
        }

        .btn:hover {
            background-color: #0d141a;
        }
        .alert {
            text-align: center; /* Center the text */
            margin: 10px auto; /* Center the alert box */
            padding: 10px; /* Add some padding */
 border-radius: 5px; /* Optional: Add rounded corners */
            width: 80%; /* Optional: Set a width */
            max-width: 600px; /* Optional: Set a maximum width */
        }

        .alert-success {
            background-color: #d4edda; /* Light green background for success */
            color:rgb(87, 53, 21); /* Dark green text */
        }

        .alert-danger {
            background-color: #f8d7da; /* Light red background for error */
            color: #721c24; /* Dark red text */
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this user?");
        }

        function fillUpdateForm(email, password) {
            document.getElementById('update_email').value = email;
            document.getElementById('update_password').value = password;
        }
    </script>
</head>
<body>
    <h1>Admin Dashboard </h1>
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
    
    <div class="form-container">
        <a href="create.php" class="btn">Create New User</a>
        <h3>Existing Users</h3>
        <table>
            <tr>
                <th>User Name</th>
                <th>Email</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <a href="edit.php?username=<?php echo urlencode($row['username']); ?>" class="btn">Edit</a>
                        <form action="" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                            <input type="hidden" name="username_to_delete" value="<?php echo $row['username']; ?>">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table><br>
    </div>
    <form action="logout.php" method="POST">
        <input type="submit" value="Logout">
    </form>
</body>
</html>

<?php
$conn->close();
?>