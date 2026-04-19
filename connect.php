<?php
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "thepagelibrary";

$con = mysqli_connect('localhost', 'root', '', 'thepagelibrary');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

