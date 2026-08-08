<?php

require "../includes/session.php";
require "../config/database.php";

$id = $_POST['id'];

$full_name = trim($_POST['full_name']);
$username = trim($_POST['username']);
$email = trim($_POST['email']);

$stmt = $pdo->prepare("
UPDATE users
SET
full_name=?,
username=?,
email=?
phone = ?
WHERE id=?
");

$stmt->execute([
$full_name,
$username,
$email,
$phone,
$id
]);

$_SESSION['full_name'] = $full_name;

header("Location:index.php");

exit;

