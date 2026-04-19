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
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginmain.php");
    exit();
}

// Handle book addition to cart with quantity
if (isset($_POST['book_id']) && isset($_POST['quantity'])) {
    $book_id = $_POST['book_id'];
    $quantity = max(1, intval($_POST['quantity'])); // Ensure quantity is at least 1
    $username = 'user_example';  // Example username, replace with actual user session or logic.

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $book_id) {
            $item['quantity'] += $quantity; // Increase quantity if book is already in cart
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['cart'][] = ['id' => $book_id, 'quantity' => $quantity]; // Add new book to cart
    }

    // Insert or update cart information in the database
    $stmt = $conn->prepare("INSERT INTO cart (order_id, book_id, book_name, username, amount, payment_mode, date, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?");
    $stmt->bind_param('iisdsdsi', $order_id, $book_id, $book_name, $username, $amount, $payment_mode, $date, $quantity, $quantity);
    // Execute the prepared statement
    $stmt->execute();
    $stmt->close();

    header("Location: cart.php");
    exit();
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

// Handle quantity update via buttons
if (isset($_GET['update_qty']) && isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $action = $_GET['update_qty'];
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $book_id) {
            if ($action == 'increase') {
                $item['quantity']++; // Increase quantity by 1
            } elseif ($action == 'decrease' && $item['quantity'] > 1) {
                $item['quantity']--; // Decrease quantity by 1, ensuring it doesn't go below 1
            }
            break;
        }
    }

    // Update cart quantity in the database
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE book_id = ? AND username = ?");
    $stmt->bind_param('iis', $item['quantity'], $book_id, $username);
    $stmt->execute();
    $stmt->close();

    header("Location: cart.php");
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
        $sql = "SELECT book_name, book_author, book_price, book_img FROM books WHERE book_id = $book_id";
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

            // Quantity Control (Increment/Decrement buttons)
            echo "<div class='quantity-controls'>";
            echo "<a href='cart.php?update_qty=decrease&book_id=" . $book_id . "' class='quantity-btn'>-</a>";
            echo "<span class='quantity-display'>" . $item['quantity'] . "</span>";
            echo "<a href='cart.php?update_qty=increase&book_id=" . $book_id . "' class='quantity-btn'>+</a>";
            echo "</div>";

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

<style>
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

/* Quantity Controls */
.quantity-controls {
    display: flex;
    align-items: center;
    margin: 10px 0;
}

.quantity-btn {
    font-size: 18px;
    padding: 5px 15px;
    background-color: #f0f0f0;
    color: #333;
    border: 1px solid #ccc;
    text-decoration: none;
    cursor: pointer;
    border-radius: 5px;
    margin: 0 5px;
}

.quantity-btn:hover {
    background-color: #ddd;
}

.quantity-display {
    font-size: 16px;
    margin: 0 10px;
}

/* Remove Button */
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