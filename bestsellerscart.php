<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "thepagelibrary";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle book removal from cart
if (isset($_GET['remove_id'])) {
    $remove_id = $_GET['remove_id'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['cart'][$key]); // Remove item from session
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
            break;
        }
    }
    header("Location: cart.php"); // Refresh the page after removal
    exit();
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo "<div class='empty-cart'>Your cart is empty.</div>";
} else {
    echo "<h2 class='cart-heading'>My Cart</h2>";
    echo "<ul class='cart-list'>";

    // Loop through the cart items
    foreach ($_SESSION['cart'] as $item) {
        // Fetch book details from the database using the book ID
        $book_id = $item['id'];
        $sql = "SELECT book_name, book_author, book_price, book_description, book_img FROM bestsellers WHERE book_id = $book_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Fetch the book details from the result
            $book = $result->fetch_assoc();

            // Display book details
            echo "<li class='cart-item'>";
            echo "<div class='cart-item-img'><img src='bookimgs/" . htmlspecialchars($book['book_img']) . "' alt='" . htmlspecialchars($book['book_name']) . "'></div>";
            echo "<div class='cart-item-details'>";
            echo "<h3 class='book-title'>" . htmlspecialchars($book['book_name']) . "</h3>";
            echo "<p class='book-author'>by " . htmlspecialchars($book['book_author']) . "</p>";
            echo "<p class='book-price'>Price: ₹" . htmlspecialchars($book['book_price']) . "</p>";
            echo "<p class='book-quantity'>Quantity: " . $item['quantity'] . "</p>";
            echo "<p class='book-description'>" . htmlspecialchars($book['book_description']) . "</p>";
            
            // Remove Button
            echo "<a href='cart.php?remove_id=" . $book_id . "' class='remove-button'>Remove</a>";

            echo "</div>";
            echo "</li>";
        } else {
            echo "<li>Book details not found for item with ID: $book_id</li>";
        }
    }

    echo "</ul>";

    // Checkout Button
    echo '<div class="checkout-container"><a href="checkout.php" class="cart-button">Proceed to Checkout</a></div>';
}
?>

<!-- CSS for Remove Button -->
<style>
.remove-button {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 12px;
    background-color: #c0392b;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.remove-button:hover {
    background-color: #a93226;
}
    /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styling */
body {
    font-family: 'Playfair Display', serif;
    background-color: #f4f1e1; /* Aged paper background */
    color: #3c2f2f; /* Vintage brown text */
    line-height: 1.6;
    padding: 20px;
}

/* Container */
.container {
    max-width: 900px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border: 1px solid #dcd0b0;
}

/* Cart Heading */
.cart-heading {
    font-size: 28px;
    text-align: center;
    margin-bottom: 20px;
    color: #8b7f4d;
}

/* Empty Cart Message */
.empty-cart {
    text-align: center;
    font-size: 20px;
    color: #8b7f4d;
}

/* Cart List */
.cart-list {
    list-style-type: none;
    padding: 0;
}

/* Cart Item */
.cart-item {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #dcd0b0;
    border-radius: 10px;
    background-color: #faf8f5;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
}

/* Item Image */
.cart-item-img img {
    width: 180px;
    height: 250px;
    object-fit: cover;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Item Details */
.cart-item-details {
    flex: 1;
}

.book-title {
    font-size: 22px;
    font-weight: bold;
    color: #3c2f2f;
    margin-bottom: 10px;
}

.book-author {
    font-size: 18px;
    color: #6f5e4c;
    margin-bottom: 5px;
}

.book-price {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
    color: #8b7f4d;
}

.book-quantity {
    font-size: 16px;
    color: #5c4a3a;
    margin-bottom: 10px;
}

.book-description {
    font-size: 16px;
    color: #4c3b30;
    line-height: 1.8;
}

/* Checkout Button */
.checkout-container {
    text-align: center;
    margin-top: 20px;
}

.cart-button {
    font-size: 18px;
    background-color: #8b7f4d;
    color: #fff;
    padding: 15px 30px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.cart-button:hover {
    background-color: #7b6c3f;
}
</style>
