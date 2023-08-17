<?php
/**
 *ENSURES THE USER HAS ACTUALLY LOGGED IN
 *IF NOT REDIRECT TO THE LOGIN PAGE HERE
 **/

session_start(); //start session
$book_id = $_GET['book_id'];


//check session for whatever user info was stored
if (!isset($_SESSION['username'])) {
    //no user info, redirect
    header("Location:login.php");
    exit();
}


require_once('includes/library.php');
$username = $_SESSION['username'];
$bookcover = $_POST['cover'] ?? null;
$coverurl = $_POST['cover-image-url'] ?? null;
$booktitle = $_POST['title'] ?? null;
$bookauthor = $_POST['author'] ?? null;
$description = $_POST['desc'] ?? null;
$rating = $_POST['rating'] ?? null;
$pubDate = $_POST['date'] ?? null;
$isbn = $_POST['isbn'] ?? null;
$tags = $_POST['tags'] ?? null;

if (isset($_POST['submit'])) {
    $pdo = connectDB();
    $query = "SELECT * FROM books WHERE book_id=$book_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $id = $stmt->fetchColumn();
    $query = "INSERT INTO books VALUES(NULL, ?, ?, ?, ?,?,?,?,?,?,?)";

    $pdo->prepare($query)->execute([$bookcover, $coverurl, $booktitle, $bookauthor, $rating, $pubDate,$description,  $isbn, $tags, $id]);
    header("Location:login.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $titlename = 'Edit Book';
    include 'includes/metadata.php';
    ?>
</head>

<body>
    <!-- Twinkling background elements -->
    <div class="stars"></div>
    <div class="twinkling"></div>
    <div class="clouds"></div>
    <!-- Create the header -->
    <?php
    $img = 'img/add.png';
    $header = 'Add book';
    include 'includes/header.php';
    ?>

    <!-- This is the main container for the addbook form -->
    <main >
        <!-- The form element that wraps all the input fields -->
        <form action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" id="addbook_form" name="addbook_form" method="post"
            class="addbook-form">
            
            <section>
                <div>
                    <h2>Add a Book to Your Library</h2>
                </div>
                <!-- A form group containing the label and input for the book cover file -->
                <div class="left">
                    <label for="cover" class="addbook-label">Book Cover:</label>
                    <input type="file" id="cover" name="cover" accept="image/*" class="addbook-input">
                </div>

                <!-- A form group containing the label and input for the book cover image URL -->
                <div>
                    <label for="cover-image-url" class="addbook-label">Cover Image URL:</label>
                    <input type="url" id="cover-image-url" name="cover-image-url" class="addbook-input"><br>
                </div>



                <!-- A form group containing the label and input for the book title -->
                <div class="left">
                    <label for="title" class="addbook-label">Book Title</label>
                    <input type="text" id="title" name="title" placeholder="Book Title" required class="addbook-input">
                </div>

                <!-- A form group containing the label and input for the book author -->
                <div>
                    <label for="author" class="addbook-label">Author</label>
                    <input type="text" id="author" name="author" placeholder="Author" required class="addbook-input">
                </div>

                <!-- A form group containing the label and input for the book rating -->
                <div>
                    <label for="rating" class="addbook-label">Rating</label>
                    <input type="range" id="rating" name="rating" min="1" max="5" class="addbook-input">
                </div>

                <!-- A form group containing the label and input for the book description -->
                <div class="addbook-form-group">
                    <label for="desc" class="addbook-label">Description</label>
                    <textarea name="desc" id="desc" cols="30" rows="10" placeholder="Description"
                        class="addbook-input"></textarea>
                </div>

                <!-- A form group containing the label and input for the book publish date -->
                <div class="addbook-form-group">
                    <label for="date" class="addbook-label">Publish Date</label>
                    <input type="date" id="date" name="date" class="addbook-input">
                </div>

                <!-- A form group containing the label and input for the book ISBN -->
                <div class="addbook-form-group">
                    <label for="isbn" class="addbook-label">ISBN</label>
                    <input type="text" id="isbn" name="isbn" placeholder="ISBN" class="addbook-input">
                </div>

                <!-- A form group containing the label and input for user tags -->
                <div class="addbook-form-group">
                    <label for="tags" class="addbook-label">Tags</label>
                    <input type="text" id="tags" name="tags" placeholder="User tags" class="addbook-input">
                </div>
                <!-- This div contains the buttons of the form, and has a class of-->
                <div class="addbook-button-group">
                    <button name="submit" type="submit" class="login-btn">Submit</button>
                    <button name="clear" type="button" class="addbook-btn-addbook-clear-btn">Clear Form</button>
                    <button name="auto" type="button" class="addbook-btn-addbook-auto-btn">Auto-Complete</button>
                </div>


            </section>

            
        </form>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>

</html>