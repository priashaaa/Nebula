<?php
$username = $_POST['username'] ?? null;
$fname = $_POST['fname'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$hash=password_hash($password, PASSWORD_DEFAULT);

require_once('includes/library.php');
session_start();
$pdo = connectDB();

$query = "SELECT * FROM users WHERE username=?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['username']]);
$current_user_result = $stmt->fetch();
if ($current_user_result) {

    $username = $current_user_result["username"];
    echo $username;
    $fname = $current_user_result["fname"];

    $email = $current_user_result["email"];
    $verify_email = $current_user_result["email"];


    // $password = $result["password"];
    // $verify_password = $result["password"];
}

if (isset($_POST['submit'])) { //only do this code if the form has been submitted

  //enter a valid username
  if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
      // if the username contains special characters or spaces
      $errors['username'] = true;
  }
  if (!isset($username) || strlen($username) === 0) {
      $errors['username'] = true;
  }

  //enter a valid firstname
  if (!preg_match('/^[a-zA-Z0-9]+$/', $fname)) {
      // if the firstname contains special characters or spaces
      $errors['fname'] = true;
  }
  if (!isset($f) || strlen($fname) === 0) {
      $errors['fname'] = true;
  }

  //enter a valid email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = true;
  }
  if (!isset($email) || strlen($email) === 0) {
      $errors['email'] = true;
  }
  if ($email !== $verify_email) {
      $errors['email_nomatch'] = true;
  }

  //enter a valid password
  if (!isset($password) || strlen($password) === 0) {
      $errors['password'] = true;
  }
  if ($password !== $verify_password) {
      $errors['password_nomatch'] = true;
  }
  if (!isset($new_password) || strlen($new_password) === 0) {
      $errors['new_password'] = true;
  }
  if ($new_password !== $verify_new_password) {
      $errors['new_password_nomatch'] = true;
  }

  // check if the password is at least 8 characters long
  if (strlen($password) < 8) {
      $errors['password_len_less_8'] = true;
  }
  if (strlen($new_password) < 8) {
      $errors['new_password_len_less_8'] = true;
  }

  // check if the password contains at least one uppercase letter
  if (!preg_match('/[A-Z]/', $password)) {
      $errors['password_noupper'] = true;
  }
  if (!preg_match('/[A-Z]/', $new_password)) {
      $errors['new_password_noupper'] = true;
  }

  // check if the password contains at least one lowercase letter
  if (!preg_match('/[a-z]/', $password)) {
      $errors['password_nolower'] = true;
  }
  if (!preg_match('/[a-z]/', $new_password)) {
      $errors['new_password_nolower'] = true;
  }

  // check if the password contains at least one number
  if (!preg_match('/[0-9]/', $password)) {
      $errors['password_nonumber'] = true;
  }
  if (!preg_match('/[0-9]/', $new_password)) {
      $errors['new_password_nonumber'] = true;
  }

  // check if the password contains at least one special character
  if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
      $errors['password_nospecial'] = true;
  }
  if (!preg_match('/[^a-zA-Z0-9]/', $new_password)) {
      $errors['new_password_nospecial'] = true;
  }


  //check if the email already exists in the database
  $query = "SELECT * FROM `users` WHERE email = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$email]);
  $result = $stmt->fetch();


  if ($result) {
      if ($result["email"] != $current_user_result["email"]) {
          $errors['email_exists'] = true;
      }
  }

  // Checking if username exists, sets an error variable if so
  $query = "SELECT * FROM `users` WHERE username = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$username]);
  $result = $stmt->fetch();

  if ($result) {
      if ($result["username"] != $current_user_result["username"]) {
          $errors['username_exists'] = true;
      }
  }
  if (!password_verify($password, $current_user_result['password_hash'])) {
      $errors['invalid_password'] = true;
  }

  //only do this if there weren't any errors
  if (count($errors) === 0) {

      // check if password in database equals to the password provided
      if (password_verify($password, $current_user_result['password_hash'])) {

          //if match then update the password to the new_password

          $query = "UPDATE bbs_registered_users SET password_hash = ? WHERE username = ?";
          $pdo->prepare($query)->execute([
              password_hash($new_password, PASSWORD_DEFAULT),
              $username
          ]);

          //go to the home page
          header("Location:index.php");
          exit();
      }




  }

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $title = "Register";
    include 'includes/metadata.php';?>
  </head>

  <body>
    <!-- Twinkling background elements -->
    <div class="stars"></div>
    <div class="twinkling"></div>
    <div class="clouds"></div>

    <!-- Page header with logo and nav bar -->
    <?php 
    $titlename='Edit Account';
    include 'includes/header.php';?>

    <main class="register">
      <section class="register">
        <h2>Edit Account</h2>

        <!-- Register form -->
        <form id="registerForm" action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" method="POST" autocomplete="off">

                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Username" value="<?= $username?>" >
                </div>

                <div>
                    <label for="fname">Full Name:</label>
                    <input type="text" id="fname" name="fname" placeholder="First Name" value="<?= $fname?>" >
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email Address" value="<?= $email?>" >

                </div>

                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Password" >

                    <label for="verifyPassword">Verify Password:</label>
                    <input type="password" id="verifyPassword" name="verifyPassword" placeholder="Verify Password"
                        required>
                </div>

                <div>
                    <input type="checkbox" id="showPassword" name="showPassword">
                    <label for="showPassword">Show Password</label>
                </div>
                <div>
                  <button id="submit" name="submit">Submit</button>

                    <!-- <input type="submit" value="Create Account"> -->
                </div>
        </form>
      </section>

      <!-- Cat head -->
      <section class="register2">
        <img src="images/vectorcat.png" height="500" alt="" />
      </section>
    </main>

    <?php include 'includes/footer.php';?>
  </body>
</html>

