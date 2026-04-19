<?php
session_start();

// Check if item index is provided
if (isset($_GET['id']) && isset($_SESSION['cart'][$_GET['id']])) {
    // Remove the item from the cart
    unset($_SESSION['cart'][$_GET['id']]);
    // Redirect back to the cart page
    header('Location: cart.php');
    exit;
} else {
    // Redirect if no item is found
    header('Location: cart.php');
    exit;
}
?>
