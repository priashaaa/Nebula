<?php
session_start(); //start session
$id = $_SESSION['id'];

//check session for whatever user info was stored
if (!isset($_SESSION['username'])) {
    //no user info, redirect
    header("Location:login.php");
    exit();
}


require_once('includes/library.php');
$pdo = connectDB();
$query = "DELETE FROM users WHERE id=$id";
$stmt = $pdo->prepare($query);
$stmt->execute();
header("Location: login.php");
exit();
?>