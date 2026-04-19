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

// Fetch books from the database based on search query
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT book_id, book_name, book_author, book_price, book_img FROM books WHERE book_name LIKE '%$search%'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>
<body>

    <h2>Search Results for: <?php echo htmlspecialchars($search); ?></h2>

    <div class="book-list">
        <?php
        if ($result->num_rows > 0) {
            while ($book = $result->fetch_assoc()) {
                echo "<div class='book-item'>";
                echo "<h3>" . htmlspecialchars($book['book_name']) . "</h3>";
                echo "<p>by " . htmlspecialchars($book['book_author']) . "</p>";
                echo "<p>Price: ₹" . htmlspecialchars($book['book_price']) . "</p>";
                echo "<img src='bookimgs/" . htmlspecialchars($book['book_img']) . "' alt='" . htmlspecialchars($book['book_name']) . "' width='100'>";
                
                // Add to Cart button
                echo "<button class='cart-button' data-id='" . $book['book_id'] . "' data-title='" . htmlspecialchars($book['book_name']) . "' data-price='" . $book['book_price'] . "'>Add to Cart</button>";
                
                // View More button
                echo "<a href='book_detail.php?book_id=" . $book['book_id'] . "'>View More</a>";
                
                echo "</div>";
            }
        } else {
            echo "<p>No books found.</p>";
        }
        ?>
    </div>

    <script>
    // Add to Cart functionality using fetch and AJAX
    document.querySelectorAll('.cart-button').forEach(button => {
        button.addEventListener('click', function() {
            const bookId = button.getAttribute('book_id');
            const bookTitle = button.getAttribute('book_name');
            const bookPrice = button.getAttribute('book_price');

            fetch('add_to_cart.php', {
                method: 'POST',
                body: new URLSearchParams({
                    book_id: bookId,
                    book_title: bookTitle,
                    book_price: bookPrice
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Book added to cart!');
                } else {
                    alert('Error adding book to cart: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an issue with adding the book to the cart.');
            });
        });
    });
    </script>

</body>
</html>
