<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "thepagelibrary";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit();
}

$user = $_SESSION['username'];
$action = $_POST['action'] ?? '';
$target_user = $_POST['target_user'] ?? '';

if ($action === "follow") {
    $stmt = $conn->prepare("INSERT IGNORE INTO followers (follower, following) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $target_user);
    if ($stmt->execute()) {
        echo json_encode(["status" => "followed"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
} elseif ($action === "unfollow") {
    $stmt = $conn->prepare("DELETE FROM followers WHERE follower = ? AND following = ?");
    $stmt->bind_param("ss", $user, $target_user);
    if ($stmt->execute()) {
        echo json_encode(["status" => "unfollowed"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
} elseif ($action === "send_message") {
    $message = $_POST['message'] ?? '';
    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user, $target_user, $message);
        if ($stmt->execute()) {
            echo json_encode(["status" => "message_sent"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    }
}

$conn->close();
?>
