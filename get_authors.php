<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thepagelibrary";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch Orders
$sql = "SELECT * FROM books where author_name, aut";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All users</title>
    <style>
        /* Vintage Styling */
        body {
            background: url('https://www.toptal.com/designers/subtlepatterns/uploads/old_map.png'); /* Vintage paper texture */
            font-family: 'Georgia', serif;
            color: #4b3621;
            margin: 20px;
        }
        h2 {
            text-align: center;
            font-size: 28px;
            color: #6b4226;
            text-shadow: 1px 1px 2px #8a6f51;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 239, 213, 0.9); /* Vintage Paper */
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
        }
        th, td {
            border: 1px solid #8b6a4b;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #c4a484;
            color: #fff;
            font-size: 18px;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f7e6d0;
        }
        tr:hover {
            background-color: #e6ccb2;
            transition: 0.3s;
        }
        /* Scrollable Table */
        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>

<h2>📜 All Users 📜</h2>

<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>role</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['role']}</td>
                    
                </tr>";
            }
        } else {
            echo "<tr><td colspan='9' style='text-align: center; font-size: 18px;'>No orders found.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

</body>
</html>
