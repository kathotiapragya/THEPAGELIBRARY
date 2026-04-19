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
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
</head>

<style>
/* Body Background Image */
body {
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

.discount-popup {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 320px;
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    display: none;
    z-index: 1000;
    font-family: Arial, sans-serif;
}

.discount-popup h3 {
    text-align: center;
    color: #333;
    margin-bottom: 10px;
}

.discount-popup p {
    font-size: 14px;
    color: #555;
    margin: 5px 0;
}

.discount-popup button {
    width: 100%;
    margin-top: 10px;
    padding: 8px;
    background-color: #8b5e3b;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.discount-popup button:hover {
    background-color: #684126;
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
    background-color: #4A4636 !important;
    color: white !important;
    padding: 20px;
    text-align: center;
}

footer * {
    color: white !important;
}
  .author-card {
    background-color: #f7f4e9;
    border-radius: 15px;
    transition: transform 0.3s;
  }
  .author-card:hover {
    transform: scale(1.05);
  }
  .author-img {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 10px;
  }
  .author-name {
    font-weight: bold;
    color: #355c7d;
  }
  .book-count {
    font-size: 14px;
    color: #777;
  }
  .dropdown-submenu {
  position: relative;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
  display: none;
  position: absolute;
}

.dropdown-submenu:hover .dropdown-menu {
  display: block;
}
.logo {
    height: 120px; /* Adjust as needed */
    width: auto;
    display: block; /* Ensures proper alignment */
}

</style>

<body>

<!-- Header Section -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
      <a href="homemain.php">
    <img src="thepagelibrarylogo.jpeg" class="logo" alt="The Page Library">
</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active" href="homemain.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="authors.php">Authors</a></li>
            <li class="nav-item"><a class="nav-link" href="bestsellers.php">Best Sellers</a></li>
            <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="genresDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Genres</a>
  <ul class="dropdown-menu" aria-labelledby="genresDropdown">
    <li><a class="dropdown-item" href="fiction.php">Fiction</a></li>
    <li><a class="dropdown-item" href="nonfiction.php">Non-Fiction</a></li>
    <li><a class="dropdown-item" href="kids.php">Kids</a></li>
  </ul>
</li>
<li class="nav-item"><a class="nav-link" href="publish_book.php">Publish</a></li>
<li class="nav-item"><a class="nav-link" href="profile.php">My Profile</a></li>
<li class="nav-item"><a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php echo count($_SESSION['cart'] ?? []); ?></sup></a></li>

</ul>
       <form class="d-flex" method="POST" action="">
  <input class="form-control me-2" type="search" placeholder="Search" name="search">
  <button class="btn btn-outline-success" type="submit">Search</button>
</form>

        </div>
      </div>
    </nav>
  </div>

  <div class="container my-5">
    <h2 class="text-center mb-4">Meet Our Authors</h2>
    
    <?php
// Handle search
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT book_author, author_img, COUNT(book_id) AS book_count FROM books 
            WHERE book_author LIKE '%$search%'
            GROUP BY book_author";
} else {
    $sql = "SELECT book_author, author_img, COUNT(book_id) AS book_count FROM books GROUP BY book_author";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';
    
    while ($row = $result->fetch_assoc()) {
        $authorName = htmlspecialchars($row['book_author']);
        $bookCount = $row['book_count'];
        $authorImg = $row['author_img']; // Fetch the image URL from the database

        // Check if the author image exists, otherwise use a default image
        if (empty($authorImg) || !file_exists("authorimgs/$authorImg")) {
            $authorImg = "authorimgs/default_avatar.jpg"; // Default author image
        } else {
            $authorImg = "authorimgs/" . $authorImg; // Use the actual image path from the database
        }

        echo '
        <div class="col">
            <div class="card text-center shadow-lg border-0 author-card">
                <img src="' . $authorImg . '" class="author-img mx-auto mt-3" alt="' . $authorName . '">
                <div class="card-body">
                    <p class="author-name">' . $authorName . '</p>
                    <p class="book-count">' . $bookCount . ' Books Available</p>
                    <a href="author_books.php?author=' . urlencode($authorName) . '" class="btn btn-hover btn-sm">View Books</a>
                </div>
            </div>
        </div>';
    }

    echo '</div>';
} else {
    echo '<h2 class="text-danger text-center">No authors found.</h2>';
}
?>
  <!-- Footer -->
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
