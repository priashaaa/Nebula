<?php
/**
 *ENSURES THE USER HAS ACTUALLY LOGGED IN
 *IF NOT REDIRECT TO THE LOGIN PAGE HERE
 **/
require_once('includes/library.php');
session_start(); //start session
//check session for whatever user info was stored
if (!isset($_SESSION['username'])) {
    //no user info, redirect
    header("Location:login.php");
    exit();
}
$pc = $_POST["pc"]?? 1;

$pdo = connectDB();
$query = "SELECT book_id,cover_url, title, author FROM users,books WHERE users.id=books.user_id";

$stmt = $pdo->query($query);
if (!$stmt) {
    die("Something went horribly wrong");
}
$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $title = "Main";
    include 'includes/metadata.php';?>
  </head>

  <body>
    <!-- Twinkling background elements -->
    <div class="stars"></div>
    <div class="twinkling"></div>
    <div class="clouds"></div>

    <!-- Page header with logo and nav bar -->
    <?php include 'includes/header.php';?>

    <main>
      <!-- Cat head and speech -->
      <section class="cat">
        <div class="cat">
          <p class="cat">Welcome back, meow...</p>
          <img src="images/vectorcat.png" height="150" alt="" />
        </div>
      </section>

      <section class="this">
        <div><h2>My Books</h2></div>

        <!-- Form for display filters -->
        <form id="displayOptions" action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" method="POST" autocomplete="off">
          <div class="buttons">
              <div>
                  <label for="sort">Sort By</label>
                  <select name="sort" id="sort">
                      <option value="1">Date Added</option>
                      <option value="2">Alphabetically</option>
                      <option value="3">Title</option>
                      <option value="4">Authors Name</option>
                  </select>
              </div>

              <div>
                  <label for="items_per_page">Items per page</label>
                  <input type="number" name="pc" id="pc" min="1" max="20"
                      value="<?= $pc ?>">
              </div>
          </div>

          <div class="smallerbuttons">
            <button name="submit" type="submit">Submit</button>
          </div>
        </form>

        <!-- All books in user's directory -->
        <div class="library">
          <!-- BOOK 1 -->
          <?php foreach ($results as $key => $row): ?>
            <?php if ($key < $pc): ?>

            <div class="books">
              <img
                src="<?php echo $row['cover_url']; ?>"
                height="200"
                alt="Book Cover of Call Me By Your Name"
              />
              <p><?php echo $row['title']; ?></p>
              <p class="author"><?php echo $row['author']; ?></p>

              <button type="button" onclick="deleteBook(<?php echo $row['book_id']; ?>)">Delete Book</button>
              <a href="register.php?book_id=<?php echo $row['book_id']; ?>">Edit Book</a>
              <button type="button" class="login-img-btn" onclick="showBookDetails(<?php echo $row['book_id']; ?>)">Book Details</button>
             </div>
            <?php endif ?>

          <?php endforeach ?>
        </div>
      </section>

    </main>
    <div id="book-details-modal" class="modal">
        <div class="modal-content">
            <!-- Add the details of the book inside the modal window -->
            <?php require_once('details.php'); ?>
        </div>
      </div>
    <?php include 'includes/footer.php';?>
</html>
