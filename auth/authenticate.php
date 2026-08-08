<?php

session_start();

require "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {

    header(
        "Location: login.php?error=" .
        urlencode("Please enter your username and password.")
    );

    exit;
}

$stmt = $pdo->prepare("
    SELECT
        id,
        full_name,
        username,
        password,
        role
    FROM users
    WHERE username = ?
    LIMIT 1
");

$stmt->execute([$username]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {

    header(
        "Location: login.php?error=" .
        urlencode("Invalid username or password.")
    );

    exit;
}

session_regenerate_id(true);

$_SESSION['user_id'] = (int)$user['id'];
$_SESSION['full_name'] = $user['full_name'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

header("Location: ../dashboard/dashboard.php");
exit;