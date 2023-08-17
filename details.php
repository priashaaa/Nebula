<?php
/****************************************
// ENSURES THE USER HAS ACTUALLY LOGGED IN
// IF NOT REDIRECT TO THE LOGIN PAGE HERE
******************************************/
require_once('includes/library.php');
session_start(); //start session
$book_id = $_GET['book_id'];

//check session for whatever user info was stored
if (!isset($_SESSION['username'])) {
  //no user info, redirect
  header("Location:login.php");
  exit();
}

$pdo = connectDB();
$query = "SELECT * FROM books WHERE book_id=$book_id";

$stmt = $pdo->query($query);
if (!$stmt) {
    die("Something went horribly wrong");
}
$results = $stmt->fetch();
?>


  <!-- Book details -->
  <section class="register">
    <div><h2><?php echo $results['title']; ?></h2></div>
    <div>
      <h3><?php echo $results['author']; ?></h3>

      <!-- Star Rating System -->
      <div class="info">
        <link
          rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        />
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star"></span>
        <span class="fa fa-star"></span>
      </div>

      <!-- Book specs -->
      <div>
        <p>
          Publish date: <?php echo $results['pubDate']; ?>
          <br />ISBN: <?php echo $results['ISBN']; ?><br />Tags: <?php echo $results['tags']; ?> <br />Pages: 336
        </p>
        <p>
        <?php echo $results['description']; ?></p>
      </div>
      <button type="button" class="close-btn" onclick="closeModal()">Close</button>
    </div>
  </section>