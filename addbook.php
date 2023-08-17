<?php
/**
 *ENSURES THE USER HAS ACTUALLY LOGGED IN
 *IF NOT REDIRECT TO THE LOGIN PAGE HERE
 **/

session_start(); //start session


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
        $query = "SELECT id FROM users WHERE username=?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);
        $id = $stmt->fetchColumn();
        $query = "INSERT INTO books VALUES(NULL, ?, ?, ?, ?,?,?,?,?,?,?)";

        $pdo->prepare($query)->execute([$bookcover, $coverurl, $booktitle, $bookauthor, $rating, $pubDate,$description,  $isbn, $tags, $id]);
        header("Location:index.php");
        exit();

    
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $titlename = 'Add book';
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
            class="addbook-form" novalidate>
            
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
                    <input type="url" id="cover-image-url" name="cover-image-url"  class="addbook-input">
                    <span class="error <?=!isset($errors['cover-image-url']) ? 'hidden' : "";?>">Please enter a valid URL</span>
                </div>



                <!-- A form group containing the label and input for the book title -->
                <div class="left">
                    <label for="title" class="addbook-label">Book Title</label>
                    <input type="text" id="title" name="title" placeholder="Book Title" required class="addbook-input">
                    <span class="error <?=!isset($errors['title']) ? 'hidden' : "";?>">Please enter a valid book title</span>
                </div>

                <!-- A form group containing the label and input for the book author -->
                <div>
                    <label for="author" class="addbook-label">Author</label>
                    <input type="text" id="author" name="author" placeholder="Author" required class="addbook-input">
                    <span class="error <?=!isset($errors['author']) ? 'hidden' : "";?>">Please enter a valid author</span>
                </div>

                <!-- A form group containing the label and input for the book rating -->
                <div>
                    <label for="rating" class="addbook-label">Rating</label>
                    <input type="range" id="rating" name="rating" min="1" max="5"  class="addbook-input">
                </div>

                <!-- A form group containing the label and input for the book description -->
                <div >
                    <label for="desc" class="addbook-label">Description</label>
                    <textarea name="desc" id="desc" cols="30" rows="10" maxlength="2500" placeholder="Description"
                     required class="addbook-input"></textarea>
                    <p><span id="desclimit">2500</span> characters left</p>
                    <span class="error <?=!isset($errors['desc']) ? 'hidden' : "";?>">Please enter a valid description</span>
                </div>

                <!-- A form group containing the label and input for the book publish date -->
                <div >
                    <label for="date" class="addbook-label">Publish Date</label>
                    <input type="date" id="date" name="date"  class="addbook-input">
                    <span class="error <?=!isset($errors['date']) ? 'hidden' : "";?>">Please choose a valid date.</span>
                </div>

                <!-- A form group containing the label and input for the book ISBN -->
                <div >
                    <label for="isbn" class="addbook-label">ISBN</label>
                    <input name="isbn" type="text" id="isbn" placeholder="ISBN"  required class="addbook-input">
                    <span class="error <?=!isset($errors['isbn']) ? 'hidden' : "";?>">Please enter a valid ISBN</span>
                </div>

                <!-- A form group containing the label and input for user tags -->
                <div>
                    <label for="tags" class="addbook-label">Tags</label>
                    <input type="text" id="tags" name="tags" placeholder="User tags"  required class="addbook-input">
                    <span class="error <?=!isset($errors['tags']) ? 'hidden' : "";?>">Please enter valid tags</span>
                </div>
                <!-- This div contains the buttons of the form, and has a class of-->
                <div class="addbook-button-group">
                    <button id="submit" name="submit" type="submit" class="login-btn">Submit</button>
                    <button name="clear" type="button" class="addbook-btn-addbook-clear-btn">Clear Form</button>
                    <button name="auto" type="button" class="addbook-btn-addbook-auto-btn">Auto-Complete</button>
                </div>


            </section>

            
        </form>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>

</html>