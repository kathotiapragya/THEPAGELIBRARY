<div class="success-container">
    <div class="success-icon">✔</div>
    <h2>Payment Successful!</h2>
    <p>Thank you for your purchase. Your order has been placed successfully.</p>
    <div class="order-summary">
        <h3>Order Summary</h3>
        <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
        <p><strong>Transaction ID:</strong> <?php echo $transaction_id; ?></p>
        <p><strong>Amount Paid:</strong> ₹<?php echo number_format($total, 2); ?></p>
        <p><strong>Payment Method:</strong> <?php echo strtoupper($payment_method); ?></p>
    </div>
    <a href="homemain.php" class="btn">Continue Shopping</a>
</div>

<style>
    .success-container {
        text-align: center;
        background: #fdf8f2;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
        max-width: 500px;
        margin: auto;
        border: 2px solid #8b4513;
        animation: fadeIn 1s ease-in-out;
    }
    .success-icon {
        font-size: 50px;
        color: #28a745;
        font-weight: bold;
    }
    h2 {
        color: #4b3621;
        font-family: 'Georgia', serif;
    }
    .order-summary {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1);
        margin: 15px 0;
    }
    .btn {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 20px;
        background-color: #8b4513;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: 0.3s;
    }
    .btn:hover {
        background-color: #4b3621;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
