<?php
include('connect.php'); // Include your database connection file

if (isset($_GET['delete_book_id'])) {
    $delete_id = $_GET['delete_book_id'];

    // SQL query to delete the book from the database
    $delete_query = "DELETE FROM `books` WHERE book_id = $delete_id";

    // Execute the query
    $result = mysqli_query($con, $delete_query);

    if ($result) {
        echo "<script>alert('Book deleted successfully.');</script>";
        echo "<script>window.location = 'view_books.php';</script>"; // Redirect back to the books page
    } else {
        echo "<script>alert('Failed to delete the book. Please try again.');</script>";
        echo "<script>window.location = 'view_books.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request. No book ID provided.');</script>";
    echo "<script>window.location = 'view_books.php';</script>";
}
?>
