<?php
require_once('includes/library.php');
//check if form is submitted 
if (isset($_POST['submit'])) {
    //get username
    $email = $_POST['email'] ?? null;
    $pdo = connectDB();
    //query to check username 
    $query = "SELECT * FROM users WHERE email=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $result = $stmt->fetch();

    //query to get email
    $query = "SELECT email FROM users WHERE email=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $email = $stmt->fetchColumn();
    $email_string = (string) $email;

    //if username is found 
    if ($result == true) {

        $password = $_POST['password'] ?? null;
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        //update user's password in database 
        $update_query = "UPDATE users SET password='$hash_password' WHERE email=?";
        $stmt = $pdo->prepare($update_query);
        $stmt->execute([$email]);
        //send email 
        include 'includes/mail.php';


    }

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $title = "Forgot Password";
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
          <p class="cat">Are you sure you tried all paw-sible options...?</p>
          <img src="images/vectorcat.png" height="150" alt="" />
        </div>
      </section>

      <section>
        <div><h2>Forgot password...</h2></div>

        <!-- Forgot password form -->
        <form action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
          <!-- Instructions -->
          <div>
            <p>
              Type in your email or password to receive a password reset link.
            </p>
          </div>

          <div>
            <label for="name">Email or username:</label>
            <input
              type="text"
              name="email"
              id="email"
              placeholder="Email"
              required
            />
          </div>

          <div>
            <label for="newpassword">New password:</label>
            <input
              type="passwords"
              name="password"
              id="password"
              placeholder="New password..."
              required
            />
          </div>

          <div>
            <input type="checkbox" id="showPassword" name="showPassword">
            <label for="showPassword">Show Password</label>
          </div>

          <!-- Cat Submit button -->
          <div class="smallerbuttons">
            <button name="submit" type="submit">Continue</button>
          </div>
        </form>
      </section>
    </main>

    <?php include 'includes/footer.php';?>
</html>
