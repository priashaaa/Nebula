<?php
require_once('includes/library.php');

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$errors = array();


if (isset($_POST['submit'])) {
    $pdo = connectDB();

    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $result = $stmt->fetch();

    if ($result) {
 
        if (password_verify($password, $result['password'])) {
            session_start();

            $_SESSION['username'] = $username;
            $_SESSION['id'] = $result['id'];

            header('Location: index.php');
            exit();
        } else {
            $errors['login'] = true;
        }
    } else {
        $errors['username'] = true;
    }

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $title = "Login";
    include 'includes/metadata.php';?>
  </head>

  <body>
    <!-- Twinkling background elements -->
    <div class="stars"></div>
    <div class="twinkling"></div>
    <div class="clouds"></div>

    <!-- Page header with logo and nav bar -->
    <?php
    $titlename="LOGIN";
    include 'includes/header.php';
    ?>

    <main>
      <section>
        <!-- Page Heading -->
        <h2>Log in</h2>

        <!-------->
        <form action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" method="POST" autocomplete="off">
            <div>
              <label for="username">Username:</label>
              <input type="text" name="username" id="username" placeholder="Username" value="<?= $username; ?>">
            </div>
            <div>
              <label for="password">Password:</label>
              <input type="password" name="password" id="password" placeholder="Password">
                
            </div>

            <div>
              <input type="checkbox" id="showPassword" name="showPassword">
              <label for="showPassword">Show Password</label>
            </div>
            <div><a href="forgot.php">Forgot Password</a></div>
            <div>
              <span class="<?=!isset($errors['username']) ? 'hidden' : ""; ?>">*That user doesn't exist</span>
              <span class="<?=!isset($errors['login']) ? 'hidden' : ""; ?>">*Incorrect login info</span>
            </div>
            <div><button name="submit" type="submit">Log In</button></div>

            <div><a href="register.php">Create Account</a></div>
        </form>
        <!-------->
      </section>
    </main>

    <?php include 'includes/footer.php';?>
  </body>
</html>
