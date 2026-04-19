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
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders - Vintage Style</title>
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

<h2>📜 All Orders - Admin Dashboard 📜</h2>

<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Order ID</th>
            <th>Book ID</th>
            <th>Book Name</th>
            <th>Username</th>
            <th>Amount</th>
            <th>Payment Mode</th>
            <th>Date</th>
            <th>Quantity</th>
        </tr>

        <?php
       if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (!is_array($row)) {
                echo "<tr><td colspan='9' style='color:red;'>Error: Invalid row data!</td></tr>";
                continue;
            }
            // Use isset() to prevent undefined array key errors
            echo "<tr>
                <td>" . (isset($row['id']) ? htmlspecialchars($row['id']) : 'N/A') . "</td>
                <td>" . (isset($row['order_id']) ? htmlspecialchars($row['order_id']) : 'N/A') . "</td>
                <td>" . (isset($row['book_id']) ? htmlspecialchars($row['book_id']) : 'N/A') . "</td>
                <td>" . (isset($row['book_name']) ? htmlspecialchars($row['book_name']) : 'N/A') . "</td>
                <td>" . (isset($row['username']) ? htmlspecialchars($row['username']) : 'N/A') . "</td>
                <td>₹" . (isset($row['amount']) ? htmlspecialchars($row['amount']) : 'N/A') . "</td>
                <td>" . (isset($row['payment_mode']) ? htmlspecialchars($row['payment_mode']) : 'N/A') . "</td>
                <td>" . (isset($row['date']) ? htmlspecialchars($row['date']) : 'N/A') . "</td>
                <td>" . (isset($row['quantity']) ? htmlspecialchars($row['quantity']) : 'N/A') . "</td>
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
