<?php
session_start();  // Start session at the beginning

$servername = "localhost";
$username = "root";
$password = "";
$database = "thepagelibrary"; 

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Best Sellers</title>

  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
</head>

<body>
<style>
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

nav.navbar {
    background-color: #4A4636 !important;
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
footer a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
}

footer a:hover {
    text-decoration: underline;
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
  .btn{
    background-color: rgb(196, 143, 97);
  }
  .btn-hover{
    color: rgb(95, 55, 25);

  }
  
</style>
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
  
  <?php
  if (isset($_POST['search']) && !empty($_POST['search'])) {
      $search = mysqli_real_escape_string($conn, $_POST['search']);

      $sql = "SELECT * FROM books 
              WHERE book_name LIKE '%$search%' 
              OR book_author LIKE '%$search%' 
              OR genre LIKE '%$search%'";

      $result = mysqli_query($conn, $sql);

      if ($result && mysqli_num_rows($result) > 0) {
          echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';
          
          while ($row = mysqli_fetch_assoc($result)) {
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
                      <button class="view-more-button" data-id="' . htmlspecialchars($row['book_id']) . '" data-title="' . htmlspecialchars($row['book_name']) . '" data-description="' . htmlspecialchars($row['book_description']) . '">View More</button>
                    </div>
                  </div>
                </div>
              </div>';
          }

          echo '</div>';
      } else {
          echo '<h2 class="text-danger text-center">No results found for "' . htmlspecialchars($search) . '"</h2>';
      }
  }
?>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Best Sellers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <style>
    /* Custom CSS for Submenu dropdown */
    .dropdown-submenu {
      position: relative;
    }
    .dropdown-submenu .dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -1px;
      display: none;
    }
    .dropdown-submenu:hover .dropdown-menu {
      display: block;
    }
    .bestsellers-heading {
    color:rgb(243, 237, 234); /* Change this to any color you want */
    font-weight: bold;
    text-align: center;
}

  </style>
</head>
<body>

 
  <div class="container mt-5">
  <h1 class="bestsellers-heading">Wohoooo! Explore today's best selling books, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>..</h1><br><br>


    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php
      // Retrieve only Romance books from the database
      $stmt = $conn->prepare("SELECT * FROM books WHERE selling = ?");
      $selling = "best";
      $stmt->bind_param("s", $selling);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '
              <div class="col">
                <div class="card shadow-lg border-0">
                  <img src="bookimgs/' . htmlspecialchars($row['Book_Img']) . '" class="card-img-top">
                  <div class="card-body text-center">
                    <p class="card-text">' . htmlspecialchars($row['book_name']) . '</p>
                    <p class="text-muted">by ' . htmlspecialchars($row['book_author']) . '</p>
                    <p class="text-muted">Price: ₹' . htmlspecialchars($row['book_price']) . '</p>
                    <div class="buttons">
                      <button class="cart-button" data-id="' . $row['book_id'] . '">Add to Cart</button>
                      <button class="view-more-button" data-bs-toggle="modal" data-bs-target="#bookModal" data-title="' . $row['book_name'] . '" data-description="' . $row['book_description'] . '">View More</button>
                    </div>
                  </div>
                </div>
              </div>';
          }
      } else {
          echo '<h3 class="text-danger text-center">No Romance books available.</h3>';
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
  <script>
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

// View More Functionality
document.querySelectorAll('.view-more-button').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('bookModalLabel').textContent = button.getAttribute('data-title');
        document.getElementById('bookDescription').textContent = button.getAttribute('data-description');
        new bootstrap.Modal(document.getElementById('bookModal')).show();
    });
});


  </script>

  <!-- JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

</body>
</html>

