<?php
session_start(); //start session
$book_id = $_GET['book_id'];

//check session for whatever user info was stored
if (!isset($_SESSION['username'])) {
    //no user info, redirect
    header("Location:login.php");
    exit();
}


require_once('includes/library.php');
$pdo = connectDB();
$query = "DELETE FROM books WHERE book_id=$book_id";
$stmt = $pdo->prepare($query);
$stmt->execute();
header("Location: index.php");
exit();
?>