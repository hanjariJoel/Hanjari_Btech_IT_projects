<?php

require "../includes/session.php";
require "../config/database.php";


/*
|--------------------------------------------------------------------------
| ALLOW POST REQUESTS ONLY
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: index.php");

    exit;
}


/*
|--------------------------------------------------------------------------
| GET FORM DATA
|--------------------------------------------------------------------------
*/

$id = (int)($_POST['id'] ?? 0);

$full_name = trim($_POST['full_name'] ?? '');
$username  = trim($_POST['username'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');


/*
|--------------------------------------------------------------------------
| BASIC VALIDATION
|--------------------------------------------------------------------------
*/

if ($id <= 0 || $full_name === '' || $username === '' || $email === '') {

    header(
        "Location: index.php?error=" .
        urlencode("Please fill in all required fields.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| EMAIL VALIDATION
|--------------------------------------------------------------------------
*/

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header(
        "Location: index.php?error=" .
        urlencode("Please enter a valid email address.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| CHECK USERNAME
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM users
    WHERE username = ?
    AND id != ?
    LIMIT 1
");

$stmt->execute([
    $username,
    $id
]);

if ($stmt->fetch()) {

    header(
        "Location: index.php?error=" .
        urlencode("That username is already in use.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| CHECK EMAIL
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM users
    WHERE email = ?
    AND id != ?
    LIMIT 1
");

$stmt->execute([
    $email,
    $id
]);

if ($stmt->fetch()) {

    header(
        "Location: index.php?error=" .
        urlencode("That email address is already in use.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| UPDATE PROFILE
|--------------------------------------------------------------------------
*/

try {

    $stmt = $pdo->prepare("
        UPDATE users
        SET
            full_name = ?,
            username = ?,
            email = ?,
            phone = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $full_name,
        $username,
        $email,
        $phone !== '' ? $phone : null,
        $id
    ]);


    /*
    |--------------------------------------------------------------------------
    | UPDATE SESSION
    |--------------------------------------------------------------------------
    */

    $_SESSION['full_name'] = $full_name;
    $_SESSION['username']  = $username;


    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    header(
        "Location: index.php?success=" .
        urlencode("Profile updated successfully.")
    );

    exit;


} catch (PDOException $e) {

    header(
        "Location: index.php?error=" .
        urlencode("Unable to update your profile. Please try again.")
    );

    exit;
}