<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thepagelibrary";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve all payment records
$sql = "SELECT * FROM user_payment";
$result = $conn->query($sql);

// Check if there are any records
if ($result->num_rows > 0) {
    // Display payments in a table
    echo "<h2>All Payments</h2>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>User ID</th>";
    echo "<th>Payment Method</th>";
    echo "<th>Payment Status</th>";
    echo "<th>Amount</th>";
    echo "<th>Transaction ID</th>";
    echo "<th>Payment Date</th>";
    echo "</tr>";

    // Loop through each payment record
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . (isset($row["user_id"]) ? $row["user_id"] : "N/A") . "</td>";
        echo "<td>" . (isset($row["payment_method"]) ? $row["payment_method"] : "N/A") . "</td>";
        echo "<td>" . (isset($row["payment_status"]) ? $row["payment_status"] : "N/A") . "</td>";
        echo "<td>" . (isset($row["amount"]) ? $row["amount"] : "N/A") . "</td>";
        echo "<td>" . (isset($row["transaction_id"]) ? $row["transaction_id"] : "N/A") . "</td>";
        echo "<td>" . (isset($row["payment_date"]) ? $row["payment_date"] : "N/A") . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No payments found.";
}

$conn->close();
?>

<style>
    body {
        font-family: 'Courier New', Courier, monospace;
        background-color: #f9f3d2;
        color: #5f4b3b;
        padding: 30px;
    }
    h2 {
        text-align: center;
        font-size: 30px;
        color: #6c4f37;
        text-shadow: 1px 1px 2px #d5bfa7;
        margin-bottom: 30px;
    }
    table {
        width: 100%;
        margin: 0 auto;
        border-collapse: collapse;
        background-color: #fff4e6;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 12px;
        text-align: center;
        border: 1px solid #9c9c9c;
    }
    th {
        background-color: #e8d1b1;
        font-size: 18px;
        font-weight: bold;
    }
    tr:nth-child(even) {
        background-color: #f9f3d2;
    }
    tr:nth-child(odd) {
        background-color: #fef2e4;
    }
    tr:hover {
        background-color: #f1e4d7;
    }
    td {
        font-size: 14px;
        color: #4a382a;
    }
    table, th, td {
        border: 1px solid #d2a679;
    }
    h2, table {
        margin: 50px auto;
    }
</style>
