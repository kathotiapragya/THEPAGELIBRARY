<?php
include('connect.php');

if(isset($_GET['edit_bookdeets'])){
    $edit_id = $_GET['edit_bookdeets'];
    //echo $edit_id;
    $get_data = "SELECT * FROM `books` WHERE book_id=$edit_id";
    $result = mysqli_query($con, $get_data);
    $row = mysqli_fetch_assoc($result);
    $book_title = $row['book_name'];
    $book_author = $row['book_author'];
    $book_description = $row['book_description'];
    $book_img = $row['Book_Img'];
    $book_price = $row['book_price'];
    $book_pages = $row['book_pages'];
    $book_genre = $row['genre'];
}
?>

<html>
<head>
    <title>Update Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    .book_img{
        width: 150px;
    }
</style>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Book Details</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-outline w-50 m-auto">
                <label for="book_title" class="form-label"> Book Title </label>
                <input type="text" value="<?php echo $book_title ?>" name="book_title" class="form-control" required="required">
            </div>

            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_author" class="form-label"> Author </label>
                <input type="text" value="<?php echo $book_author ?>" name="book_author" class="form-control" required="required">
            </div>

            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_desc" class="form-label"> Description </label>
                <input type="text" value="<?php echo $book_description ?>" name="book_desc" class="form-control" required="required">
            </div>

            <div class="form-outline w-50 m-auto mb-4">
                <label for="genres" class="form-label">Genres</label>
                <select name="genres" id="genres" class="form-select" required>
                    <option value="">Select Genre</option>
                    <option value="Romance" <?php if ($book_genre == 'Romance') echo 'selected'; ?>>Romance</option>
                    <option value="Mystery" <?php if ($book_genre == 'Mystery') echo 'selected'; ?>>Mystery</option>
                    <option value="Science Fiction" <?php if ($book_genre == 'Science Fiction') echo 'selected'; ?>>Science Fiction</option>
                    <option value="Adventure" <?php if ($book_genre == 'Adventure') echo 'selected'; ?>>Adventure</option>
                    <option value="Young Adult" <?php if ($book_genre == 'Young Adult') echo 'selected'; ?>>Young Adult</option>
                    <option value="Fantasy" <?php if ($book_genre == 'Fantasy') echo 'selected'; ?>>Fantasy</option>
                    <option value="Self-Help" <?php if ($book_genre == 'Self-Help') echo 'selected'; ?>>Self-Help</option>
                    <option value="Biographies" <?php if ($book_genre == 'Biographies') echo 'selected'; ?>>Biographies</option>
                    <option value="History" <?php if ($book_genre == 'History') echo 'selected'; ?>>History</option>
                    <option value="Philosophy" <?php if ($book_genre == 'Philosophy') echo 'selected'; ?>>Philosophy</option>
                    <option value="Science" <?php if ($book_genre == 'Science') echo 'selected'; ?>>Science</option>
                    <option value="Early Reads" <?php if ($book_genre == 'Early Reads') echo 'selected'; ?>>Early Reads</option>
                </select>
            </div>

            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_img1" class="form-label">Book Image</label>
                <div class="d-flex">
                    <input type="file" name="book_img1" id="book_img1" class="form-control">
                    <img src="./bookimgs/<?php echo $book_img ?>" alt="book" class="book_img">
                </div>
            </div>

            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_price" class="form-label"> Price </label>
                <input type="text" value="<?php echo $book_price ?>" name="book_price" class="form-control" required="required">
            </div>

            <div class="form-outline w-50 m-auto mb-4">
                <label for="book_page" class="form-label"> Pages </label>
                <input type="text" value="<?php echo $book_pages ?>" name="book_page" class="form-control" required="required">
            </div>

            <div class="form-outline mb-4">
                <input type="submit" name="edit_Book" class="btn-info" value="Update Book">
            </div>
        </form>         
    </div>

    <!-- edit books -->
    <?php
if (isset($_POST['edit_Book'])) {
    // Capture the temporary file name
    $temp_img = $_FILES['book_img1']['tmp_name'];

    // Your other variables
    $book_title = mysqli_real_escape_string($con, $_POST['book_title']);
    $book_author = mysqli_real_escape_string($con, $_POST['book_author']);
    $book_description = mysqli_real_escape_string($con, $_POST['book_desc']);
    $book_price = mysqli_real_escape_string($con, $_POST['book_price']);
    $book_pages = mysqli_real_escape_string($con, $_POST['book_page']);
    $book_genre = mysqli_real_escape_string($con, $_POST['genres']);

    if (empty($book_title) || empty($book_author) || empty($book_description) || empty($book_genre) || empty($book_price) || empty($book_pages)) {
        echo "<script>alert('Fill all the details')</script>";
    } else {
        // Handle image upload
        if (!empty($temp_img)) {
            $new_image_name = time() . "_" . $_FILES['book_img1']['name'];
            move_uploaded_file($temp_img, "./bookimgs/$new_image_name");
            $book_img = $new_image_name; // Set new image name
        } else {
            // Retain old image if no new image is uploaded
            $book_img = $row['Book_Img'];
        }

        // Updating the book details
        $update_books = "UPDATE `books` SET 
            book_name='$book_title', 
            book_description='$book_description', 
            book_author='$book_author', 
            Book_Img='$book_img', 
            book_price='$book_price', 
            book_pages='$book_pages', 
            genre='$book_genre', 
            date=NOW() 
            WHERE book_id=$edit_id";

        $result_update = mysqli_query($con, $update_books);
        if ($result_update) {
            echo "<script>alert('Yay, updated successfully!')</script>";
            echo "<script>window.open('./view_books.php', '_self')</script>";
        } else {
            echo "<script>alert('Error updating book. Please try again.')</script>";
        }
    }
}
?>
</body>
</html>
