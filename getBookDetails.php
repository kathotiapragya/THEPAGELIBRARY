<?php
// Database Connection Details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thepagelibrary";

// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get book ID from POST request
$bookId = isset($_POST['bookId']) ? intval($_POST['bookId']) : 0; // Ensure the key matches what you send from the front-end

// Debugging: Log the book ID
error_log("Book ID: " . $bookId);

// Query to get Book Details
$sql = "SELECT book_name, book_author, book_pages, book_price, book_description FROM books WHERE book_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        // Return book details as a JSON response
        echo json_encode($book);
    } else {
        // Debugging: Log if no book was found
        error_log("No book found with ID: " . $bookId);
        echo json_encode([]);
    }

    $stmt->close();
} else {
    // Handle SQL preparation error
    error_log("Failed to prepare SQL statement.");
    echo json_encode(['error' => 'Failed to prepare SQL statement.']);
}
$conn->close();
?>