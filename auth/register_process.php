<?php

require_once "../config/database.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: register.php");

    exit;
}


/* ==========================================================
   GET FORM DATA
========================================================== */

$full_name = trim($_POST['full_name'] ?? '');

$username = trim($_POST['username'] ?? '');

$email = trim($_POST['email'] ?? '');

$phone = trim($_POST['phone'] ?? '');

$password = $_POST['password'] ?? '';

$confirm_password = $_POST['confirm_password'] ?? '';


/* ==========================================================
   VALIDATION
========================================================== */

if (
    $full_name === '' ||
    $username === '' ||
    $email === '' ||
    $phone === '' ||
    $password === '' ||
    $confirm_password === ''
) {

    header(
        "Location: register.php?error=" .
        urlencode("Please fill in all required fields.")
    );

    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header(
        "Location: register.php?error=" .
        urlencode("Please enter a valid email address.")
    );

    exit;
}


if (strlen($password) < 8) {

    header(
        "Location: register.php?error=" .
        urlencode("Password must contain at least 8 characters.")
    );

    exit;
}


if ($password !== $confirm_password) {

    header(
        "Location: register.php?error=" .
        urlencode("Passwords do not match.")
    );

    exit;
}


/* ==========================================================
   CHECK EXISTING USER
========================================================== */

try {

    $stmt = $pdo->prepare("
        SELECT id
        FROM users
        WHERE username = :username
           OR email = :email
        LIMIT 1
    ");

    $stmt->execute([
        ':username' => $username,
        ':email' => $email
    ]);


    if ($stmt->fetch()) {

        header(
            "Location: register.php?error=" .
            urlencode(
                "A user with that username or email already exists."
            )
        );

        exit;
    }


    /* ======================================================
       HASH PASSWORD
    ====================================================== */

    $hashed_password = password_hash(
        $password,
        PASSWORD_DEFAULT
    );


    /* ======================================================
       CREATE PENDING STOREKEEPER
    ====================================================== */

    $stmt = $pdo->prepare("
        INSERT INTO users
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
            :full_name,
            :username,
            :email,
            :phone,
            :password,
            'Storekeeper',
            'Pending'
        )
    ");


    $stmt->execute([

        ':full_name' => $full_name,

        ':username' => $username,

        ':email' => $email,

        ':phone' => $phone,

        ':password' => $hashed_password

    ]);


    header(
        "Location: login.php?registered=1"
    );

    exit;


} catch (PDOException $e) {

    header(
        "Location: register.php?error=" .
        urlencode("Registration failed. Please try again.")
    );

    exit;
}