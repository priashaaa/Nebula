<?php
/****************************************
// ENSURES THE USER HAS ACTUALLY LOGGED IN
// IF NOT REDIRECT TO THE LOGIN PAGE HERE
******************************************/

session_start(); //start session


//check session for whatever user info was stored
if (!isset($_SESSION['username'])) {
  //no user info, redirect
  header("Location:login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $title = "Search for a book...";
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
      <section class="this">
        <div><h2>Results</h2></div>

        <!-- Search form-->
        <form action="processform.php" method="get">
          <input type="search" id="query" name="q" placeholder="Search..." />
          <div><button>Search</button></div>

          <!-- Search filter buttons -->
          <div class="buttons">
            <div>
              <label for="sort">Sort By</label>
              <select name="sort" id="sort">
                <option value="">A-Z</option>
                <option value="1">Z-A</option>
                <option value="2">Most Popular</option>
                <option value="6">Trending</option>
              </select>

              <label for="items">Items per Page</label>
              <select name="items" id="items">
                <option value="">5</option>
                <option value="1">10</option>
                <option value="2">25</option>
                <option value="3">50</option>
                <option value="4">100</option>
                <option value="5">Scroll View</option>
              </select>
            </div>
          </div>
        </form>

        <!-- All books from search -->
        <div class="library">
          <!-- BOOK 1 -->
          <div class="books">
            <img
              src="images/CMBYN.jpg"
              height="200"
              alt="Book Cover of Call Me By Your Name"
            />
            <p>Call Me By Your Name</p>
            <p class="author">André Aciman</p>

            <a href="addbook.php">Add Book</a>
            <a href="details.php">Details</a>
          </div>

          <!-- BOOK 2 -->
          <div class="books">
            <img
              src="images/ConversationsWFriends.jpg"
              height="200"
              alt="Book Cover of Call Me By Your Name"
            />
            <p>Conversations With Friends</p>
            <p class="author">Sally Rooney</p>

            <a href="addbook.php">Add Book</a>
            <a href="details.php">Details</a>
          </div>

          <!-- BOOK 3 -->
          <div class="books">
            <img
              src="images/Frog&Toad.jpg"
              height="200"
              alt="Book Cover of Call Me By Your Name"
            />
            <p>Frog and Toad are Friends</p>
            <p class="author">Arnold Label</p>

            <a href="addbook.php">Add Book</a>
            <a href="details.php">Details</a>
          </div>

          <!-- BOOK 4 -->
          <div class="books">
            <img
              src="images/TULOB.jpg"
              height="200"
              alt="Book Cover of Call Me By Your Name"
            />
            <p>The Unbearable Lightness of Being</p>
            <p class="author">Milan Kundera</p>

            <a href="addbook.php">Add Book</a>
            <a href="details.php">Details</a>
          </div>

          <!-- BOOK 5 -->
          <div class="books">
            <img
              src="images/YAH.jpg"
              height="200"
              alt="Book Cover of Call Me By Your Name"
            />
            <p>You Are Here</p>
            <p class="author">Thich Nhat Hanh</p>

            <a href="addbook.php">Add Book</a>
            <a href="details.php">Details</a>
          </div>
        </div>
      </section>
    </main>

    <?php include 'includes/footer.php';?>
  </body>
</html>
