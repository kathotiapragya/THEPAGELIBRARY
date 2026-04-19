<?php
// Start the session at the very top
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "thepagelibrary";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginmain.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);

    // Define upload directories
    $image_dir = "uploads/images/"; // Directory for book covers
    $pdf_dir = "uploads/pdfs/"; // Directory for book files

    // Ensure directories exist
    if (!file_exists($image_dir)) {
        mkdir($image_dir, 0777, true);
    }
    if (!file_exists($pdf_dir)) {
        mkdir($pdf_dir, 0777, true);
    }

    // Handle image upload
    $image_name = basename($_FILES["cover_image"]["name"]);
    $image_path = $image_dir . time() . "_" . $image_name;
    $imageFileType = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));

    // Validate image
    $check = getimagesize($_FILES["cover_image"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    $allowed_image_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_image_types)) {
        die("Only JPG, JPEG, PNG, and GIF files are allowed for the cover image.");
    }

    if (!move_uploaded_file($_FILES["cover_image"]["tmp_name"], $image_path)) {
        die("Error uploading cover image.");
    }

    // Handle PDF upload
    $pdf_name = basename($_FILES["book_file"]["name"]);
    $pdf_path = $pdf_dir . time() . "_" . $pdf_name;
    $pdfFileType = strtolower(pathinfo($pdf_path, PATHINFO_EXTENSION));

    if ($pdfFileType != "pdf") {
        die("Only PDF files are allowed for book upload.");
    }

    if (!move_uploaded_file($_FILES["book_file"]["tmp_name"], $pdf_path)) {
        die("Error uploading book file.");
    }

    // Get current timestamp
    $submission_date = date('Y-m-d H:i:s');

    // Insert query with image and PDF paths
    $sql = "INSERT INTO published_books (title, author, cover_image, book_file, submission_date) VALUES ('$title', '$author', '$image_path', '$pdf_path', '$submission_date')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Book published successfully!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish Your Book - The Page Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
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
 /* Stylish Form Container */
.publish-form {
    background: linear-gradient(135deg, #f5e1c8, #e7c9a9); /* Elegant warm gradient */
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    border: 2px solid #8b5e3b; /* Vintage brown border */
    width: 65%;
    margin: 60px auto;
    text-align: center;
    font-family: 'Georgia', serif;
}

/* Input Fields Styling */
.publish-form input[type="text"],
.publish-form input[type="file"] {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: 1px solid #a66b45;
    border-radius: 8px;
    background: #fffaf3; /* Soft cream */
    color: #5d4037;
    font-size: 16px;
    box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

/* Placeholder Text */
.publish-form input::placeholder {
    color: #8d6e63;
    opacity: 0.8;
    font-style: italic;
}

/* Hover and Focus Effects */
.publish-form input:focus {
    border: 1px solid #8b5e3b;
    background: #fff5e1;
    box-shadow: 0 0 8px rgba(139, 94, 59, 0.5);
    outline: none;
}

/* File Upload Styling */
.publish-form input[type="file"] {
    padding: 8px;
    cursor: pointer;
}

/* 📖 Publish Button */
.btn-publish {
    background: linear-gradient(135deg, #a66b45, #8b5e3b);
    color: white;
    padding: 12px 18px;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
    font-family: 'Georgia', serif;
}

/* Hover Effect for Button */
.btn-publish:hover {
    background: linear-gradient(135deg, #8b5e3b, #6d4c41);
    transform: scale(1.05);
}

/* 📱 Responsive Design */
@media (max-width: 768px) {
    .publish-form {
        width: 85%;
        padding: 25px;
    }
}



        /* Styling for Published Books */
        .published-books {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .book-card {
            background-color: #fff8e1;
            border: 2px solid #c48f61;
            border-radius: 15px;
            padding: 15px;
            width: 250px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .book-card img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .book-card h3 {
            font-size: 18px;
            margin-top: 10px;
            color: #5d4037;
        }

        .book-card p {
            font-size: 14px;
            color: #6d4c41;
        }

        .book-card a {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #c48f61;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .book-card a:hover {
            background-color: #a66b45;
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
footer a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
}

footer a:hover {
    text-decoration: underline;
}
    </style>
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
        </div>
      </div>
    </nav>
  </div>

 
<form class="publish-form" method="POST" action="" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Book Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="author" class="form-label">Author Name</label>
        <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>" required>
    </div>
    <div class="mb-3">
        <label for="cover_image" class="form-label">Upload Book Cover</label>
        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*" required>
    </div>
    <div class="mb-3">
        <label for="book_file" class="form-label">Upload Book (PDF)</label>
        <input type="file" class="form-control" id="book_file" name="book_file" accept="application/pdf" required>
    </div>
    <button type="submit" class="btn btn-publish">Publish Book</button>
</form>

<?php
// Fetch and display books
$result = $conn->query("SELECT * FROM published_books ORDER BY submission_date DESC");
    echo "<div class='published-books'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='book-card'>";
        echo "<img src='" . htmlspecialchars($row['cover_image']) . "' alt='Book Cover'>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>Author: " . htmlspecialchars($row['author']) . "</p>";
        echo "<a href='" . htmlspecialchars($row['book_file']) . "' target='_blank'>Download PDF</a>";
        echo "</div>";
    }
    echo "</div>";
    

// Close connection at the very end
$conn->close();
?>
<!-- Bootstrap JavaScript (for dropdown functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<footer style="background-color: #4A4636 !important; color: white !important;">
    <p>&copy; 2024 The Page Library.</p>
    <div>
      <a href="contact.html">Contact Us</a>
      <a href="privacy.html">Privacy Policy</a>
      <a href="tos.html">Terms of Service</a>
      <a href="about.html">About</a>
    </div>
  </footer>
</body>
</html>
