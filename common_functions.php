<?php
// Include the database connection file once
include_once('connection.php');

// Function to fetch and display books
function getbooks() {
    global $con; // Use the global connection variable correctly (should match your connection variable in connection.php)
    
    // Check if the connection exists
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    
    // Start HTML output
    echo '<div class="container my-5">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';

    // SQL query to fetch book data
    $sql = "SELECT book_id, book_name, book_author, book_description, Book_Img, book_price, genre FROM books LIMIT 8";
    $result = $con->query($sql); // Use $con here, not $conn

    // Check if any results were returned
    if ($result && $result->num_rows > 0) {
        // Fetch each book and display it
        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="col">
                <div class="card shadow-lg border-0" style="background-color: #f7f4e9; border-radius: 15px;">
                    <img src="bookimgs/' . htmlspecialchars($row['Book_Img']) . '" class="card-img-top" alt="' . htmlspecialchars($row['book_name']) . '">
                    <div class="card-body text-center">
                        <p class="card-text" style="font-family: \'Palatino Linotype\', serif; color: #355c7d;">' . htmlspecialchars($row['book_name']) . '</p>
                        <p class="text-muted">by ' . htmlspecialchars($row['book_author']) . '</p>
                        <p class="text-muted">Genre: ' . htmlspecialchars($row['genre']) . '</p>
                        <p class="text-muted">Price: ₹' . htmlspecialchars($row['book_price']) . '</p>
                        <div class="buttons">
                            <button class="cart-button" data-id="' . htmlspecialchars($row['book_id']) . '" data-title="' . htmlspecialchars($row['book_name']) . '" data-price="' . htmlspecialchars($row['book_price']) . '">Add to Cart</button>
                            <button class="view-more-button" data-title="' . htmlspecialchars($row['book_name']) . '" data-description="' . htmlspecialchars($row['book_description']) . '">View More</button>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<p class="text-center">No books available at the moment.</p>';
    }

    // Close the HTML container
    echo '</div>
          </div>';
}
?>
