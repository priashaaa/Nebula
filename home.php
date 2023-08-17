

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $title = "Default";
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
          <p class="cat">The greatest book log in the galaxy!</p>
        </div>
        <div class="cat">
          <img src="images/vectorcat.png" height="400" alt="cartoon cat head" />
        </div>

        <!-- Log in and Register buttons -->
        <div>
          <nav class="account">
            <ul>
              <li><a href="login.php" class="home">Sign In</a></li>
              <li><a href="register.php" class="home">Join</a></li>
            </ul>
          </nav>
        </div>
      </section>
    </main>

    <?php include 'includes/footer.php';?>
  </body>
</html>
