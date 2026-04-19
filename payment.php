<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thepagelibrary";

$con = mysqli_connect($servername, $username, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo "<div class='empty-cart'>Your cart is empty. Please add items before proceeding to payment.</div>";
    exit;
}

// Calculate total amount
$total = 0;
$order_id = uniqid("ORD");
$date = date("Y-m-d H:i:s");
$current_username = $_SESSION['username'] ?? 'Guest';

foreach ($_SESSION['cart'] as $item) {
    $book_id = $item['id'];

    // Fetch book details securely
    $stmt = $con->prepare("SELECT book_name, book_price FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        $total += $book['book_price'] * $item['quantity'];
    } else {
        die("<div class='error'>Error: Book ID $book_id not found in database.</div>");
    }
    $stmt->close();
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST['payment_method'];
    $payment_status = "Success"; 
    $transaction_id = uniqid("TXN_");

    if ($payment_status == "Success") {
        $user_id = $_SESSION['user_id'] ?? 0; 
        $query = "INSERT INTO user_payment (user_id, payment_method, payment_status, amount, transaction_id, payment_date)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("issdss", $user_id, $payment_method, $payment_status, $total, $transaction_id, $date);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            foreach ($_SESSION['cart'] as $item) {
                $book_id = $item['id'];
                $quantity = $item['quantity'];

                $stmt = $con->prepare("SELECT book_name, book_price FROM books WHERE book_id = ?");
                $stmt->bind_param("i", $book_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $book = $result->fetch_assoc();
                    $book_name = $book['book_name'];
                    $amount = $book['book_price'] * $quantity;

                    $cart_query = "INSERT INTO cart (order_id, book_id, book_name, username, amount, payment_mode, date)
                                   VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt_cart = $con->prepare($cart_query);
                    $stmt_cart->bind_param("sissdss", $order_id, $book_id, $book_name, $current_username, $amount, $payment_method, $date);
                    $stmt_cart->execute();
                    $stmt_cart->close();
                }
                $stmt->close();
            }

            unset($_SESSION['cart']);

            echo "<div class='success-message'>
                    <h2>Payment Successful! 🎉</h2>
                    <p class='greet'>Thank you for your purchase!</p>
                    <div class='details'>
                        <p><span class='highlight'>Order ID:</span> $order_id</p>
                        <p><span class='highlight'>Transaction ID:</span> $transaction_id</p>
                        <p><span class='highlight'>Amount Paid:</span> ₹" . number_format($total, 2) . "</p>
                    </div>
                    <p class='info'>Your order will be processed shortly. You will be redirected soon.</p>
                    <p class='redirect'>Redirecting in 5 seconds...</p>
                  </div>";

            echo "<meta http-equiv='refresh' content='5;url=homemain.php'>";
            exit;
        } else {
            echo "<div class='error'>Error in recording payment details. Please try again.</div>";
        }
    } else {
        echo "<div class='error'>Payment failed. Please try again.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script>
        function toggleAddressFields() {
            let paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            document.getElementById('detailed-address').style.display = paymentMethod === "COD" ? "block" : "none";
            document.getElementById('upi-id').style.display = paymentMethod === "UPI" ? "block" : "none";
        }
    </script>
    <style>
   body {
    font-family: 'Courier New', Courier, monospace;
    background: url('paymentbg.webp') no-repeat center center fixed;
    background-size: cover;
    color: #4b3621;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Full height */
}

.container {
    max-width: 600px;
    width: 90%;
    background: rgba(245, 225, 201, 0.95); /* Light parchment with transparency */
    padding: 25px;
    border-radius: 12px;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.4);
    border: 3px solid #8b4513;
    text-align: center;
    animation: fadeIn 0.8s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

h2 {
    color: #4b3621;
    font-family: 'Georgia', serif;
    text-shadow: 1px 1px 2px #8b4513;
}

.payment-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
    font-size: 1.1rem;
    text-align: left;
}

input[type="radio"] {
    margin-right: 10px;
}

.total {
    font-size: 1.4rem;
    font-weight: bold;
    margin-top: 20px;
    border-top: 2px dashed #8b4513;
    padding-top: 10px;
    text-align: center;
}

button {
    background: linear-gradient(to bottom, #c4a484, #8b4513);
    color: white;
    border: 2px solid #8b4513;
    padding: 12px 20px;
    font-size: 1.2rem;
    font-family: 'Georgia', serif;
    border-radius: 6px;
    display: block;
    margin: 25px auto 0;
    box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}

button:hover {
    background: #8b4513;
    transform: scale(1.08);
}

#upi-id {
    font-style: italic;
    font-size: 1.1rem;
    color: #8b4513;
    background: rgba(255, 255, 255, 0.6);
    padding: 8px;
    border-radius: 5px;
    width: fit-content;
    margin: 15px auto;
}

/* Vintage Success Message Styling */
.success-message {
    background: url('aged-paper-texture.jpg') no-repeat center center;
    background-size: cover;
    border: 5px solid #5a3e1b;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 8px 8px 20px rgba(0, 0, 0, 0.3);
    max-width: 600px;
    margin: auto;
    font-family: 'Playfair Display', serif;
    text-align: center;
    position: relative; /* Needed for fireworks positioning */
    color: #4b3621;
    animation: fadeIn 1.2s ease-in-out;
}

h2 {
    color: #5a3e1b;
    font-size: 2rem;
    text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
    font-family: 'Great Vibes', cursive;
}

.greet {
    font-size: 1.4rem;
    color: #3d2a16;
    font-style: italic;
}

.details {
    background: rgba(243, 224, 197, 0.8);
    padding: 20px;
    border-radius: 10px;
    border: 3px dashed #5a3e1b;
    margin-top: 15px;
    text-align: left;
}

.details p {
    margin: 5px 0;
    font-size: 1.2rem;
    font-family: 'Merriweather', serif;
}

.highlight {
    color: #b45f06;
    font-weight: bold;
}

.info {
    font-style: italic;
    font-size: 1.2rem;
    color: #5a3e1b;
    margin-top: 12px;
    font-family: 'Garamond', serif;
}

.redirect {
    font-size: 1.2rem;
    font-weight: bold;
    color: #5a3e1b;
    margin-top: 20px;
    text-decoration: underline;
    font-family: 'Cinzel', serif;
}

/* Fireworks Effect */
.fireworks-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
}

.firework {
    position: absolute;
    width: 5px;
    height: 5px;
    background: gold;
    border-radius: 50%;
    opacity: 0;
    animation: firework-animation 1.5s infinite ease-out;
}

@keyframes firework-animation {
    0% {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
    50% {
        transform: translateY(-100px) scale(1.5);
        opacity: 0.8;
    }
    100% {
        transform: translateY(-200px) scale(0);
        opacity: 0;
    }
}

/* Adding Multiple Fireworks */
.firework:nth-child(1) { left: 10%; animation-delay: 0.2s; }
.firework:nth-child(2) { left: 30%; animation-delay: 0.4s; }
.firework:nth-child(3) { left: 50%; animation-delay: 0.6s; }
.firework:nth-child(4) { left: 70%; animation-delay: 0.8s; }
.firework:nth-child(5) { left: 90%; animation-delay: 1s; }

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}


    </style>
</head>
<body>

<div class="container">
    <h2>Payment</h2>
    <form method="POST">
        <label class="form-label">Choose Payment Method:</label>
        <select id="payment_method" name="payment_method" class="form-select" onchange="togglePaymentFields()">
            <option value="UPI">UPI</option>
            <option value="Card">Debit/Credit Card</option>
            <option value="COD">Cash on Delivery (COD)</option>
        </select>

<!-- UPI ID Display -->
<div id="upi-id" style="
    display: flex; 
    flex-direction: column; 
    align-items: center; 
    background: rgba(255, 248, 220, 0.8); 
    padding: 15px; 
    border-radius: 12px; 
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    width: fit-content; 
    margin: auto;
">
    <p style="font-weight: bold; color: #8b4513; font-size: 18px; margin: 0;">
        UPI ID: <span style="font-style: italic;">pragyakathotia12</span>
    </p>
    <img src="upiqr.jpg" alt="Scan to Pay" 
        style="width: 200px; height: 200px; margin-top: 10px; border-radius: 10px; 
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);">
</div>



        <!-- Card Details Section -->
        <div id="card-details" style="display: none;">
            <label class="form-label">Card Number:</label>
            <input type="text" class="form-control" name="card_number" placeholder="XXXX-XXXX-XXXX-XXXX">

            <label class="form-label">Expiration Date:</label>
            <input type="month" class="form-control" name="exp_date">

            <label class="form-label">CVV:</label>
            <input type="password" class="form-control" name="cvv" placeholder="XXX" maxlength="3">
        </div>


        <div class="total">Total Amount: ₹<?php echo number_format($total, 2); ?></div>
        <button type="submit" class="btn btn-primary mt-3">Proceed to Payment</button>
    </form>
</div>
<script>
    function togglePaymentFields() {
        let paymentMethod = document.getElementById("payment_method").value;
        
        document.getElementById('upi-id').style.display = (paymentMethod === "UPI") ? "block" : "none";
        document.getElementById('card-details').style.display = (paymentMethod === "Card") ? "block" : "none";
        document.getElementById('detailed-address').style.display = (paymentMethod === "COD") ? "block" : "none";
    }
</script>

</body>
</html>