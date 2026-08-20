<?php

require "../config/database.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: register.php");

    exit;
}


/*
|--------------------------------------------------------------------------
| GET FORM DATA
|--------------------------------------------------------------------------
*/

$full_name = trim($_POST['full_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';


/*
|--------------------------------------------------------------------------
| BASIC VALIDATION
|--------------------------------------------------------------------------
*/

if (
    $full_name === '' ||
    $username === '' ||
    $email === '' ||
    $password === '' ||
    $confirm_password === ''
) {

    header(
        "Location: register.php?error=" .
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
        "Location: register.php?error=" .
        urlencode("Please enter a valid email address.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| PASSWORD CONFIRMATION
|--------------------------------------------------------------------------
*/

if ($password !== $confirm_password) {

    header(
        "Location: register.php?error=" .
        urlencode("Passwords do not match.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| PASSWORD LENGTH
|--------------------------------------------------------------------------
*/

if (strlen($password) < 8) {

    header(
        "Location: register.php?error=" .
        urlencode("Password must contain at least 8 characters.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| CHECK USERNAME
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare(
    "SELECT id
     FROM users
     WHERE username = ?
     LIMIT 1"
);

$stmt->execute([$username]);

if ($stmt->fetch()) {

    header(
        "Location: register.php?error=" .
        urlencode("That username is already registered.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| CHECK EMAIL
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare(
    "SELECT id
     FROM users
     WHERE email = ?
     LIMIT 1"
);

$stmt->execute([$email]);

if ($stmt->fetch()) {

    header(
        "Location: register.php?error=" .
        urlencode("That email address is already registered.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| HASH PASSWORD
|--------------------------------------------------------------------------
*/

$hashed_password = password_hash(
    $password,
    PASSWORD_DEFAULT
);


/*
|--------------------------------------------------------------------------
| CREATE STOREKEEPER ACCOUNT
|--------------------------------------------------------------------------
|
| IMPORTANT:
|
| The role is deliberately hard-coded as Storekeeper.
| A person registering through this page cannot register
| themselves as an Administrator.
|
| Status is Pending until an administrator approves them.
|--------------------------------------------------------------------------
*/

try {

    $stmt = $pdo->prepare(
        "INSERT INTO users
        (
            full_name,
            username,
            email,
            phone,
            password,
            role,
            status
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            'Storekeeper',
            'Pending'
        )"
    );

    $stmt->execute([
        $full_name,
        $username,
        $email,
        $phone !== '' ? $phone : null,
        $hashed_password
    ]);


    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    header(
        "Location: register.php?success=" .
        urlencode(
            "Registration submitted successfully. " .
            "Your account is now awaiting administrator approval."
        )
    );

    exit;


} catch (PDOException $e) {

    header(
        "Location: register.php?error=" .
        urlencode(
            "Registration failed. Please try again."
        )
    );

    exit;
}