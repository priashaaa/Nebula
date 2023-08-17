<?php
$username = $_POST['username'] ?? null;
$fname = $_POST['fname'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$hash=password_hash($password, PASSWORD_DEFAULT);

require_once('includes/library.php');
$pdo = connectDB();

if (isset($_POST['submit'])) {
  
  $query = "INSERT INTO users VALUES(NULL, ?, ?, ?, ?)";
  $pdo->prepare($query)->execute([$username, $fname, $email,$hash]);
  header("Location:index.php");
  exit();
    
}
?>

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
    <?php 
    $titlename='Register';
    include 'includes/header.php';?>

    <main class="register">
      <section class="register">
        <h2>Create an account</h2>

        <!-- Register form -->
        <form name="registerForm" id="registerForm" action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" method="POST" >

                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username"  placeholder="Username" onblur="checkUsername()" >
                    <span class="error <?=!isset($errors['username']) ? 'hidden' : "";?>">Please enter a valid username</span>
                    <span id="usernameerror"></span>
                </div>
                <div class="register-form-group">
                    <label for="username" class="register-label">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" onblur="checkUsername()"
                        class="register-input">
                    <span id="usernameError" class="error hidden">Username is invalid or taken, if you change your input
                        please click out of the textfield and try again.</span>
                </div>

                <div>
                    <label for="firstname">First Name:</label>
                    <input type="text" id="fname" name="fname"  placeholder="First Name" >
                    <span class="error <?=!isset($errors['fname']) ? 'hidden' : "";?>">Please enter a valid name</span>
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email Address" >
                    <span class="error <?=!isset($errors['email']) ? 'hidden' : "";?>">Please enter a valid email</span>
                </div>

                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" oninput="checkPassword()"  placeholder="Password" > 
                    <span class="error <?=!isset($errors['password']) ? 'hidden' : "";?>">Please enter a valid password</span>  
                    <span id="passworderror"></span>                

                    <label for="verifyPassword">Verify Password:</label>
                    <input type="password" id="verifyPassword" name="verifyPassword" placeholder="Verify Password"
                        >
                </div>

                <div>
                    <input type="checkbox" id="showPassword" name="showPassword">
                    <label for="showPassword">Show Password</label>
                </div>
                <div>
                  <button type="submit"id="submit" name="submit">Create Account</button>
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

