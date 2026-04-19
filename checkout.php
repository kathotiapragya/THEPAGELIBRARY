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

// Initialize total, discount, and messages
$total = 0;
$discount_amount = 0;
$final_total = 0;
$discount_message = "";
$show_popup = false; // Control the popup visibility

// Check if discount code is applied
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['discount_code'])) {
    $discount_code = strtoupper(trim($_POST['discount_code'])); // Convert to uppercase & trim spaces
    $_SESSION['discount_code'] = $discount_code; // Store in session
}

// Retrieve the discount code from session if it exists
$discount_code = $_SESSION['discount_code'] ?? '';

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo "<div class='empty-cart'>Your cart is empty.</div>";
    exit;
}

// Fetch cart details and calculate total
foreach ($_SESSION['cart'] as $item) {
    $book_id = $item['id'];
    $sql = "SELECT book_name, book_author, book_price FROM books WHERE book_id = $book_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        $totalPrice = $book['book_price'] * $item['quantity'];
        $total += $totalPrice;
    }
}


// Apply discount logic if a code is provided
if ($discount_code) {
    if ($discount_code === "NEW10") {
        $discount_amount = $total * 0.10;
        $discount_message = "New User Discount (10%) Applied!";
        $show_popup = true;
    } elseif ($discount_code === "LIBRARY10" && $total > 1000) {
        $discount_amount = $total * 0.10;
        $discount_message = "Library Discount (10%) Applied!";
        $show_popup = true;
    } elseif ($discount_code === "LIBRARY15" && $total > 1500) {
        $discount_amount = $total * 0.15;
        $discount_message = "Library Discount (15%) Applied!";
        $show_popup = true;
    } elseif ($discount_code === "LIBRARY25" && $total > 5000) {
        $discount_amount = $total * 0.25;
        $discount_message = "Library Discount (25%) Applied!";
        $show_popup = true;
    } else {
        $discount_message = "Invalid Code or Minimum Order Not Met!";
        $show_popup = true;
    }
}

// Calculate final total after discount
$final_total = $total - $discount_amount;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }
        th {
            background-color: #343a40;
            color: white;
        }
        .total {
            font-size: 1.2rem;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .btn-checkout {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: center;
            background-color:rgb(126, 93, 58);
            color: white;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-checkout:hover {
            background-color:rgb(70, 47, 18);
        }
        .navbar {
            margin-bottom: 20px;
        }
        .discount-input {
            width: 200px;
        }
        /* Popup Styling */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            text-align: center;
        }
        .popup.show {
            display: block;
        }
        .popup button {
            margin-top: 10px;
            padding: 8px 16px;
            background:rgb(124, 87, 39);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Navbar for discount code input -->
<nav class="navbar navbar-light bg-light">
    <div class="container">
        <form class="d-flex" method="POST" action="">
            <input class="form-control discount-input" type="text" placeholder="Enter discount code" name="discount_code" value="<?php echo htmlspecialchars($discount_code); ?>">
            <button class="btn btn-outline-success" type="submit">Apply</button>
        </form>
    </div>
</nav>

<!-- Discount Popup -->
<div id="discountPopup" class="popup">
    <p><?php echo htmlspecialchars($discount_message); ?></p>
    <button onclick="closePopup()">OK</button>
</div>

<div class="container">
    <h2>Checkout Summary</h2>
    <table class="table table-bordered">
        <tr>
            <th>Book Name</th>
            <th>Author</th>
            <th>Quantity</th>
            <th>Price (₹)</th>
            <th>Total (₹)</th>
        </tr>
        <?php
        foreach ($_SESSION['cart'] as $item) {
            $book_id = $item['id'];
            $sql = "SELECT book_name, book_author, book_price FROM books WHERE book_id = $book_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $book = $result->fetch_assoc();
                $totalPrice = $book['book_price'] * $item['quantity'];
                echo "<tr>
                        <td>" . htmlspecialchars($book['book_name']) . "</td>
                        <td>" . htmlspecialchars($book['book_author']) . "</td>
                        <td>" . htmlspecialchars($item['quantity']) . "</td>
                        <td>₹" . htmlspecialchars($book['book_price']) . "</td>
                        <td>₹" . htmlspecialchars($totalPrice) . "</td>
                    </tr>";
            }
        }
        ?>
    </table>

    <div class="total">
        Subtotal: ₹<?php echo $total; ?><br>
        Discount Applied: ₹<?php echo $discount_amount; ?><br>
        <strong>Final Amount: ₹<?php echo $final_total; ?></strong>
    </div>

    <a href="payment.php" class="btn-checkout">Proceed to Payment</a>
</div>

<script>
    function closePopup() {
        document.getElementById('discountPopup').classList.remove('show');
    }
    <?php if ($show_popup): ?>
        document.getElementById('discountPopup').classList.add('show');
    <?php endif; ?>
</script>

</body>
</html>

<?php
$conn->close();
?>
