<?php
$servername = "localhost";  
$username = "root";         
$password = "";             
$database = "thepagelibrary"; 

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authors - The Page Library</title>
  
  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <style>body {
    background: url('v1.jpg') no-repeat center center fixed;
    background-size: cover;
}

.logo {
    height: 120px;
    width: auto;
    display: block;
}

.buttons {
    margin-top: 10px;
}

.buttons button {
    margin: 5px;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.cart-button {
    background-color: rgb(175, 139, 76);
    color: white;
}

.view-more-button {
    background-color: rgb(114, 81, 52);
    color: white;
}

.btn {
    background-color: rgb(196, 143, 97);
}

.btn-hover {
    color: rgb(95, 55, 25);
}



/* Ensure dropdown menu background matches navbar */
.dropdown-menu {
    background-color: #4A4636 !important; /* Matches navbar */
    border: none; /* Optional: removes the border if needed */
}

.dropdown-menu a {
    color: white !important; /* Ensures text is visible */
}

.dropdown-menu a:hover {
    background-color: #6a644f !important; /* Slightly lighter for hover effect */
}


.welcome-section {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
}

.welcome-section h1,
.welcome-section h3,
.welcome-section p,
.welcome-section a {
    color: black;
}

nav {
    background-color: #4A4636;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    padding: 15px 30px;
}

nav ul li a {
    color: white !important;
    text-decoration: none;
    padding: 10px 15px;
    font-size: 18px;
    font-family: 'Georgia', serif;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

nav ul li a:hover {
    color: white !important;
}

nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    padding: 0;
    gap: 20px;
}

nav ul li {
    position: relative;
}

form .form-control {
    background-color: transparent;
    color: white;
    border: 1px solid white;
}

form .form-control::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.btn-outline-success {
    color: white !important;
    border-color: white !important;
}

.btn-outline-success:hover {
    background-color: white !important;
    color: black !important;
}

footer {
    background-color: #4A4636;
    color: white !important;
    padding: 20px;
    text-align: center;
}

footer * {
    color: white !important;
}
h2 {
  color: white;
  text-shadow: 2px 2px 5px rgba(255, 255, 255, 0.8);
  font-size: 3rem; /* Adjust the size as needed */
  font-weight: bold;
}
</style>
  
  <!-- Custom CSS -->

</head>

<body>
  <!-- Header Section -->
  <div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <img src="thepagelibrarylogo.jpeg" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="homemain.php">Home</a></li>
            <li class="nav-item"><a class="nav-link active" href="#">Authors</a></li>
            <li class="nav-item"><a class="nav-link" href="bestsellers.php">Best Sellers</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Genres</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="fiction.php">Fiction</a></li>
                <li><a class="dropdown-item" href="nonfiction.php">Non-Fiction</a></li>
                <li><a class="dropdown-item" href="kids.php">Kids</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="publish_book.php">Publish</a></li>
            <li class="nav-item"><a class="nav-link" href="profile.php">My Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php echo count($_SESSION['cart'] ?? []); ?></sup></a></li>
          </ul>
          
        </div>
      </div>
    </nav>
  </div>

  <!-- Author Filter Section -->
  <div class="container my-4">
    <h2 class="text-center">YOU CAN NOW FILTER BOOKS BY AUTHOR </h2>
    <form method="GET" class="text-center">
      <label for="author" class="form-label">Filter by Author:</label>
      <select name="author" id="author" class="form-select w-50 mx-auto">
        <option value="">All Authors</option>
        <?php
          $authorQuery = "SELECT DISTINCT book_author FROM books ORDER BY book_author ASC";
          $authorResult = $conn->query($authorQuery);
          while ($authorRow = $authorResult->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($authorRow['book_author']) . '">' . htmlspecialchars($authorRow['book_author']) . '</option>';
          }
        ?>
      </select>
      <button type="submit" class="btn btn-primary mt-2">Filter</button>
    </form>
  </div>

  <!-- Author Books Section -->
  <div class="container my-5">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php
      $selectedAuthor = $_GET['author'] ?? '';
      $sql = "SELECT book_id, book_name, book_author, book_description, Book_Img, book_price FROM books";
      if (!empty($selectedAuthor)) {
          $sql .= " WHERE book_author = '" . mysqli_real_escape_string($conn, $selectedAuthor) . "'";
      }
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '
              <div class="col">
                <div class="card shadow-lg border-0" style="background-color: #f7f4e9; border-radius: 15px;">
                  <img src="bookimgs/' . htmlspecialchars($row['Book_Img']) . '" class="card-img-top" alt="' . htmlspecialchars($row['book_name']) . '">
                  <div class="card-body text-center">
                    <p class="card-text" style="font-family: \'Palatino Linotype\', serif; color: #355c7d;">' . htmlspecialchars($row['book_name']) . '</p>
                    <p class="text-muted">by ' . htmlspecialchars($row['book_author']) . '</p>
                    <p class="text-muted">Price: ₹' . htmlspecialchars($row['book_price']) . '</p>
                    <button class="view-more-button btn btn-sm btn-dark" 
                      data-title="' . htmlspecialchars($row['book_name']) . '" 
                      data-description="' . htmlspecialchars($row['book_description']) . '">View More</button>
                                            <button class="cart-button" data-id="' . $row['book_id'] . '">Add to Cart</button>

                  </div>
                </div>
              </div>';
          }
      } else {
          echo '<h2 class="text-danger text-center">No books found.</h2>';
      }
      ?>
    </div>
  </div>

  <!-- Modal for Book Details -->
  <div class="modal fade" id="bookModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bookModalLabel">Book Title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p id="bookDescription">Book Description</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <footer style="background-color: #4A4636 !important; color: white !important;">
    <p>&copy; 2024 The Page Library.</p>
    <div>
      <a href="contact.html">Contact Us</a>
      <a href="privacy.html">Privacy Policy</a>
      <a href="tos.html">Terms of Service</a>
      <a href="about.html">About</a>
    </div>
  </footer>
  <!-- JavaScript -->
  <script>
    document.querySelectorAll('.view-more-button').forEach(button => {
      button.addEventListener('click', () => {
        document.getElementById('bookModalLabel').textContent = button.getAttribute('data-title');
        document.getElementById('bookDescription').textContent = button.getAttribute('data-description');
        new bootstrap.Modal(document.getElementById('bookModal')).show();
      });
    });

    document.querySelectorAll('.cart-button').forEach(button => {
    button.addEventListener('click', function() {
        const bookId = button.getAttribute('data-id');
        const bookTitle = button.getAttribute('data-title');
        const bookPrice = button.getAttribute('data-price');

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
