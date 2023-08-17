# 3420 Assignment #4 - Winter 2023

Name(s):Priasha Barua

Live Loki link(s):https://loki.trentu.ca/~priashabarua/3420/assignments/assn4/register.php

## Rubric

| Component                                                    | Grade |
| :----------------------------------------------------------- | ----: |
| Add Book Validation \*                                       |    /5 |
| Create Account Validation \*                                 |    /5 |
| Delete confirmation \*                                       |    /3 |
| Details modal \*                                             |    /3 |
|                                                              |       |
| Collapsible Nav                                              |    /3 |
| Unique Username \*                                           |    /3 |
| Password Strength                                            |    /3 |
| Show Password \*                                             |    /3 |
| Summary Limit \*                                             |    /3 |
| Star Rating                                                  |    /3 |
|                                                              |       |
| Code Quality (tidyness, validity, efficiency, etc)           |    /4 |
| Documentation                                                |    /3 |
| Testing                                                      |    /3 |
|                                                              |       |
| Bonus                                                        |    /2 |
| Deductions (readability, submission guidelines, originality) |       |
|                                                              |       |
| Total                                                        |   /35 |

## Table of Contents

1. Add Book

2. Create Account

3. Delete confirmation

4. Details modal

5. Unique Username

6. Show Password

7. Summary Limit

## Code & Testing
![Add Book](./images/addbookval.png)

## Add Book

```php + html
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
```

## Create Account
![Create Account](./images/createacc.png)
![Password Val 1](./images/pass1.png)
![Password Val 2](./images/pass3.png)

```php + html
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

                <div>
                    <label for="firstname">First Name:</label>
                    <input type="text" id="fname" name="fname"  placeholder="First Name" >
                    <span class="error <?=!isset($errors['fname']) ? 'hidden' : "";?>">Please enter a valid name</span>
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email Address" >
                    <span class="error <?=!isset($errors['email']) ? 'hidden' : "";?>">Please enter a valid email</span>

                    <label for="verifyEmail">Verify Email:</label>
                    <input type="email" id="verifyEmail" name="verifyEmail" placeholder="Verify Email Address" >
                </div>

                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password"  placeholder="Password" >
                    <span class="error <?=!isset($errors['password']) ? 'hidden' : "";?>">Please enter a valid password</span>

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
```
## Delete Confirmation
![Delete Book pop up](./images/deletebook.png)
![Delete acc pop up](./images/deleteacc.png)

## Details
![Book modal window](./images/bookdetails.png)

```php
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
```

## Check Username
![Username exists](./images/username.png)

```php
<?php

require_once('includes/library.php');

$username = $_POST['username'] ?? null;

$pdo = connectDB();

$query = "SELECT ID FROM `users` WHERE username = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
$response = array('exists' => $stmt->rowCount() > 0);

header('Content-Type: application/json');
echo json_encode($response); ?>
<?php

require_once('includes/library.php');

$username = $_POST['username'] ?? null;

$pdo = connectDB();

$query = "SELECT ID FROM `users` WHERE username = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
$response = array('exists' => $stmt->rowCount() > 0);

header('Content-Type: application/json');
echo json_encode($response); ?>
```

# Show Password

![Hidden password](./images/hidepass.png)
![Show password](./images/showpass.png)
![Register Hidden password](./images/registerhidepass.png)
![Register show password](./images/registershowpass.png)

# Summary Limit

![Description empty](./images/descriptionbefore.png)
![Description with text](./images/descriptionafter.png)

# Javascript

```js
"use strict";

/**********************************************/
/*                                            */
/*           Register Functions               */
/*                                            */
/**********************************************/

/*       SHOW PASSWORD      */
const showPasswordCheckbox = document.querySelector("#showPassword");
const passwordInput = document.querySelector("#password");
const verifyPassword = document.querySelector("#verifyPassword");
if (showPasswordCheckbox) {
  showPasswordCheckbox.addEventListener("click", function () {
    if (this.checked) {
      passwordInput.type = "text";
      verifyPassword.type = "text";
    } else {
      passwordInput.type = "password";
      verifyPassword.type = "password";
    }
  });
}
/**********************************************/
/*                                            */
/*        Create Account Functions           */
/*                                            */
/**********************************************/

/*       CHECK USERNAME      */
function checkUsername() {
  let usernameInput = document.getElementById("username");
  let usernameError = document.getElementById("usernameerror");
  let username = usernameInput.value.trim();
  if (username === "") {
    usernameError.textContent = "";
    return;
  }
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);
        if (response.exists) {
          usernameError.textContent = "Username already taken";
          usernameError.style.color = "red";
        } else {
          usernameError.textContent = "";
        }
      } else {
        console.error(xhr.statusText);
      }
    }
  };
  xhr.open("POST", "check-username.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("username=" + encodeURIComponent(username));
}

/**********************************************/
/*                                            */
/*                  Index                     */
/*                                            */
/**********************************************/

/*       SHOW BOOK DETAILS      */
function showBookDetails(bookId) {
  // Create the backdrop element
  var backdrop = document.createElement("div");
  backdrop.classList.add("modal-backdrop");
  document.body.appendChild(backdrop);

  // Get the modal element and show it
  var modal = document.getElementById("book-details-modal");
  modal.style.display = "block";

  // Make an AJAX request to the details.php file to get the book details
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Set the contents of the modal content div to the book details
      var modalContent = modal.querySelector(".modal-content");
      modalContent.innerHTML = this.responseText;
    }
  };
  xmlhttp.open("GET", "details.php?book_id=" + bookId, true);
  xmlhttp.send();
}
function closeModal() {
  // Get the wrapper div for the modal
  var modalWrapper = document.getElementById("book-details-modal");
  // Hide the modal by setting the display property of the wrapper div to none
  modalWrapper.style.display = "none";
}

/*       DELETE BOOK      */
function deleteBook(book_id) {
  if (confirm("Are you sure you want to delete this book?")) {
    // Call deletebook.php with the book ID
    window.location.href = "deletebook.php?book_id=" + book_id;
  }
}

/*       DELETE USER      */
function deleteAccount() {
  if (confirm("Are you sure you want to delete your account?")) {
    // Call deleteaccount.php
    window.location.href = "deleteaccount.php";
  }
}

/**********************************************/
/*                                            */
/*            Add Book Functions             */
/*                                            */
/**********************************************/

/*       DESCRIPTION LIMIT      */

const plotSummaryInput = document.getElementById("desc");
const plotSummaryCounter = document.getElementById("desclimit");
if (plotSummaryInput) {
  plotSummaryInput.addEventListener("input", () => {
    const charactersLeft = 2500 - plotSummaryInput.value.length;
    plotSummaryCounter.textContent = charactersLeft;
  });
}

/*       VALID URL      */
function isValidURL(url) {
  const urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
  return urlRegex.test(url);
}

/*       VALID ISBN      */
function isValidISBN(string) {
  return /^(97(8|9))?\d{9}[\d|X]$/i.test(string.replace(/[-\s]/g, ""));
}

// This block will run when the DOM is loaded (once elements exist)
window.addEventListener("DOMContentLoaded", () => {
  const addbookForm = document.querySelector("#addbook_form");
  if (addbookForm) {
    /***********************************/
    /*            Add Book             */
    /***********************************/
    addbookForm.addEventListener("submit", (ev) => {
      //declare a boolean flag valid set to false for determining if there were any errors found below
      let error = false;

      /****   validating url   ****/
      const coverImageUrlInput = document.querySelector("#cover-image-url");
      const coverImageUrlError = coverImageUrlInput.nextElementSibling;

      if (isValidURL(coverImageUrlInput.value)) {
        coverImageUrlError.classList.add("hidden");
      } else {
        coverImageUrlError.classList.remove("hidden");
        error = true;
      }

      /****   validating book title   ****/
      const titleInput = document.querySelector("#title");
      const titleError = titleInput.nextElementSibling; // select the next sibling element with class "error"

      if (!titleInput.value.trim() == "") {
        titleError.classList.add("hidden");
      } else {
        titleError.classList.remove("hidden");
        error = true;
      }

      /****   validating author  ****/
      const authorInput = document.querySelector("#author");
      const authorError = authorInput.nextElementSibling; // select the next sibling element with class "error"

      if (!authorInput.value.trim() == "") {
        authorError.classList.add("hidden");
      } else {
        authorError.classList.remove("hidden");
        error = true;
      }

      /****   validating description   ****/
      const descInput = document.querySelector("#desc");
      const descError = descInput.nextElementSibling; // select the next sibling element with class "error"

      if (!descInput.value.trim() == "") {
        descError.classList.add("hidden");
      } else {
        descError.classList.remove("hidden");
        error = true;
      }

      /****   validating publish date   ****/
      const publishDateInput = document.querySelector("#date");
      const publishDateError = publishDateInput.nextElementSibling;
      if (publishDateInput.value) {
        const today = new Date();
        const selectedDate = new Date(publishDateInput.value);

        if (selectedDate > today) {
          publishDateError.classList.remove("hidden");
          error = true;
        } else {
          publishDateError.classList.add("hidden");
        }
      } else {
        publishDateError.classList.remove("hidden");
        error = true;
      }

      /****   validating ISBN   ****/
      const isbnInput = document.querySelector("#isbn");
      const isbnError = isbnInput.nextElementSibling;

      if (isValidISBN(isbnInput.value)) {
        isbnError.classList.add("hidden");
      } else {
        isbnError.classList.remove("hidden");
        error = true;
      }

      // Make this conditional on if there are errors.
      if (error) {
        ev.preventDefault(); //STOP FORM SUBMISSION IF THERE ARE ERRORS
      }
    });
  }

  /***********************************/
  /*            Register             */
  /***********************************/

  const register = document.querySelector("#registerForm");
  if (register) {
    register.addEventListener("submit", (ev) => {
      //declare a boolean flag valid set to false for determining if there were any errors found below
      let error = false;

      /****   validating username   ****/
      const usernameInput = document.querySelector("#username");
      const usernameError = usernameInput.nextElementSibling; // select the next sibling element with class "error"

      if (!usernameInput.value.trim() == "") {
        usernameError.classList.add("hidden");
      } else {
        usernameError.classList.remove("hidden");
        error = true;
      }

      /****   validating username   ****/
      const emailInput = document.querySelector("#email");
      const emailError = emailInput.nextElementSibling; // select the next sibling element with class "error"

      if (!usernameInput.value.trim() == "") {
        emailError.classList.add("hidden");
      } else {
        emailError.classList.remove("hidden");
        error = true;
      }

      /****   validating username   ****/
      const passwordInput = document.querySelector("#password");
      const passwordError = passwordInput.nextElementSibling; // select the next sibling element with class "error"

      if (!passwordInput.value.trim() == "") {
        passwordError.classList.add("hidden");
      } else {
        passwordError.classList.remove("hidden");
        error = true;
      }

      // Make this conditional on if there are errors.
      if (error) {
        ev.preventDefault(); //STOP FORM SUBMISSION IF THERE ARE ERRORS
      }
    });
  }
});
```


Put your code and screenshots here, with proper heading organization. You don't need to include html/php code (or testing) for any pages that aren't affected by your javascript for this assignment.
