"use strict";
let error = false;
function checkUsername() {
    let usernameInput = document.getElementById("username");
    let username = usernameInput.value.trim();
    let usernameError = document.getElementById("usernameError");
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    usernameError.classList.remove('hidden');
                    error = true;
                } else {

                    error = false;
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
// This function is correct, don't mess with it. It uses a regular expression to return true if the provided gps is valid and false if it isn't.
function isValidURL(url) {
    const urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
    return urlRegex.test(url);
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email.trim());
}

// This function checks if the provided string is a valid ISBN-10 or ISBN-13 code
function isValidISBN(string) {
    return /^(97(8|9))?\d{9}[\d|X]$/i.test(string.replace(/[-\s]/g, ""));
}

function isValidPassword(password) {
    const strongPasswordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[^\s]{8,}$/;
    return strongPasswordRegex.test(password);
}
// This function deletes a book with the given ID
function deleteBook(book_id) {
    if (confirm("Are you sure you want to delete this book?")) {
        // Call deletebook.php with the book ID
        window.location.href = "deletebook.php?$_SESSION['username'];=" + book_id;
    }
}

// This function deletes the current user's account
function deleteAccount() {
    if (confirm("Are you sure you want to delete your account?")) {
        // Call deleteaccount.php
        window.location.href = "deleteaccount.php";
    }
}

// This function shows the details of a book with the given ID in a modal dialog
function showBookDetails(bookId) {
    // Create the backdrop element
    var backdrop = document.createElement('div');
    backdrop.classList.add('modal-backdrop');
    document.body.appendChild(backdrop);

    // Get the modal element and show it
    var modal = document.getElementById('book-details-modal');
    modal.style.display = 'block';

    // Make an AJAX request to the details.php file to get the book details
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Set the contents of the modal content div to the book details
            var modalContent = modal.querySelector('.modal-content');
            modalContent.innerHTML = this.responseText;
        }
    };
    xmlhttp.open('GET', 'details.php?book_id=' + bookId, true);
    xmlhttp.send();
}

// This function hides the book details modal
function closeModal() {
    // Get the wrapper div for the modal
    var modalWrapper = document.getElementById('book-details-modal');
    // Hide the modal by setting the display property of the wrapper div to none
    modalWrapper.style.display = 'none';
}



// This block will run when the DOM is loaded (once elements exist), it's really only necessary as an IE 9 fallback for lack of support for defer
window.addEventListener("DOMContentLoaded", () => {

    const showPasswordCheckbox = document.querySelector("#showPassword");
    const passwordInput = document.querySelector("#password");
    const verifyPassword = document.querySelector("#vpassword");

    showPasswordCheckbox.addEventListener("click", function () {
        if (this.checked) {
            passwordInput.type = "text";
            verifyPassword.type = "text";
        } else {
            passwordInput.type = "password";
            verifyPassword.type = "password";
        }
    });

    // Find the add book form on the page
    const addbookForm = document.querySelector('#addbook_form');

    if (addbookForm) {

        // ADDBOOK VALIDATION
        addbookForm.addEventListener('submit', (ev) => {

            // Prevent the form from actually submitting to the server


            // Declare a boolean flag error set to false for determining if there were any errors found below
            let error = false;

            // Validate the book title
            const titleInput = document.querySelector('#title');
            const titleError = titleInput.nextElementSibling; // select the next sibling element with class "error"

            if (!titleInput.value.trim() == "") {
                titleError.classList.add('hidden');
            } else {
                titleError.classList.remove('hidden');
                error = true;
            }

            // Validate the book author
            const authorInput = document.querySelector('#author');
            const authorError = authorInput.nextElementSibling; // select the next sibling element with class "error"

            if (!authorInput.value.trim() == "") {
                authorError.classList.add('hidden');
            } else {
                authorError.classList.remove('hidden');
                error = true;
            }

            // validating book description
            const descInput = document.querySelector("#desc");
            const descError = descInput.nextElementSibling; // select the next sibling element with class "error"
            if (!descInput.value.trim() == "") {
                descError.classList.add("hidden");
            } else {
                descError.classList.remove("hidden");
                error = true;
            }
            // validating book ISBN
            const isbnInput = document.querySelector('#isbn');
            const isbnError = isbnInput.nextElementSibling;
            if (isValidISBN(isbnInput.value)) {
                isbnError.classList.add('hidden');
            } else {
                isbnError.classList.remove('hidden');
                error = true;
            }

            // validating book cover image URL
            const coverImageUrlInput = document.querySelector('#cover-image-url');
            const coverImageUrlError = coverImageUrlInput.nextElementSibling;

            if (isValidURL(coverImageUrlInput.value)) {
                coverImageUrlError.classList.add('hidden');

            } else {
                coverImageUrlError.classList.remove('hidden');
                error = true;
            }

            // validating book cover
            const coverInput = document.querySelector("#cover");
            const coverError = coverInput.nextElementSibling;

            if (coverInput.files.length === 0) {
                coverError.classList.remove("hidden");
                coverError.textContent = "Please upload an image file";
            } else {
                const fileType = coverInput.files[0].type;
                if (!fileType.startsWith("image/")) {
                    coverError.classList.remove("hidden");
                    coverError.textContent = "Invalid file type. Please upload an image file.";
                } else {
                    coverError.classList.add("hidden");
                }
            }

            // validating ebook upload
            const ebookInput = document.querySelector("#ebook");
            const ebookError = ebookInput.nextElementSibling;

            if (ebookInput.files.length === 0) {
                ebookError.classList.remove("hidden");
                ebookError.textContent = "Please upload an ebook pdf";
                error = true;
            } else {
                const fileType = ebookInput.files[0].type;
                if (fileType !== "application/pdf") {
                    ebookError.classList.remove("hidden");
                    ebookError.textContent = "Invalid file type. Please upload a pdf file.";
                    error = true;
                } else {
                    ebookError.classList.add("hidden");
                }
            }

            // validating book publish date
            const publishDateInput = document.querySelector('#date');
            const publishDateError = publishDateInput.nextElementSibling;
            if (publishDateInput.value) {
                const today = new Date();
                const selectedDate = new Date(publishDateInput.value);

                if (selectedDate > today) {
                    publishDateError.classList.remove('hidden');
                    error = true;
                } else {
                    publishDateError.classList.add('hidden');
                }
            } else {
                publishDateError.classList.remove('hidden');
                error = true;
            }



            if (error) {
                ev.preventDefault();
            }


        });
    }


    const registerForm = document.querySelector('#register_form');

    if (registerForm) {
        let usernameInput = document.getElementById("username");
        usernameInput.addEventListener('blur', () => {
            checkUsername();
        });

        registerForm.addEventListener('submit', (ev) => {
            let error = false;

            let usernameInput = document.getElementById("username");
            let usernameError = document.getElementById("usernameError");
            if (!usernameInput.value.trim() == "") {
                usernameError.classList.add('hidden');
            } else {
                usernameError.classList.remove('hidden');
                error = true;
            }

            let nameInput = document.getElementById("fname");
            let nameError = document.getElementById("nameError");
            if (!nameInput.value.trim() == "") {
                nameError.classList.add('hidden');
            } else {
                nameError.classList.remove('hidden');
                error = true;
            }

            const emailInput = document.getElementById("email");
            const emptyEmailMsg = document.getElementById("validEmail");
            const vemailInput = document.getElementById("vemail");
            const emailMatchError = document.getElementById("matchEmail");
            const emailValue = emailInput.value.trim();
            const vemailValue = vemailInput.value.trim();

            if (emailValue !== vemailValue) {
                emailMatchError.classList.remove("hidden");
                error = true;
            } else {
                emailMatchError.classList.add("hidden");
            }

            if (!isValidEmail(emailInput.value)) {
                emptyEmailMsg.classList.remove('hidden');
                error = true;
            } else {
                emptyEmailMsg.classList.add('hidden');
            }

            const passwordInput = document.getElementById("password");
            const passwordValue = passwordInput.value.trim();
            const vpasswordInput = document.getElementById("vpassword");
            const vpasswordValue = vpasswordInput.value.trim();
            const validPasswordError = document.getElementById("validPassword");
            const passwordMatchError = document.getElementById("matchPassword");

            if (passwordValue !== vpasswordValue) {
                passwordMatchError.classList.remove("hidden");
                error = true;
            } else {
                passwordMatchError.classList.add("hidden");
            }

            if (!isValidPassword(passwordInput.value)) {
                validPasswordError.classList.remove('hidden');
                error = true;
            } else {
                validPasswordError.classList.add('hidden');
            }

            if (error) {
                ev.preventDefault();
            }
        });
    }

});
