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