<?php
session_start();
include 'db_connection.php'; // Ensure correct DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = intval($_POST['book_id']);
    $new_quantity = intval($_POST['quantity']);

    if ($new_quantity < 1) {
        echo "error"; // Prevent invalid quantities
        exit;
    }

    // Update session cart
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $book_id) {
            $item['quantity'] = $new_quantity;
            break;
        }
    }

    // Update cart table in database
    $stmt = $con->prepare("UPDATE cart SET quantity = ? WHERE book_id = ?");
    $stmt->bind_param("ii", $new_quantity, $book_id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
