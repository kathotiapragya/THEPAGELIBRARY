<?php
session_start();  // Ensure the session is started

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the cart session exists, if not initialize it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get the POST data from the AJAX request
if (isset($_POST['book_id'], $_POST['book_title'], $_POST['book_price'])) {
    $bookId = $_POST['book_id'];
    $bookTitle = $_POST['book_title'];
    $bookPrice = $_POST['book_price'];

    // Check if the book is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $bookId) {
            $item['quantity'] += 1; // If found, increase the quantity
            $found = true;
            break;
        }
    }

    // If not found, add the new book to the cart
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $bookId,
            'title' => $bookTitle,
            'price' => $bookPrice,
            'quantity' => 1
        ];
    }

    // Send a JSON response to confirm the operation
    echo json_encode(['success' => true]);
} else {
    // If required data is missing, send an error response
    echo json_encode(['success' => false, 'message' => 'Missing book details']);
}
?>
