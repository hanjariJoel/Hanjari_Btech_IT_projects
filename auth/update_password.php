<?php

require "../config/database.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: login.php");

    exit;
}


$token = $_POST['token'] ?? '';

$password = $_POST['password'] ?? '';

$confirmPassword = $_POST['confirm_password'] ?? '';


/*
|--------------------------------------------------------------------------
| BASIC VALIDATION
|--------------------------------------------------------------------------
*/

if (
    $token === '' ||
    $password === '' ||
    $confirmPassword === ''
) {

    header(
        "Location: login.php?error=" .
        urlencode("Invalid password reset request.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| PASSWORD MATCH
|--------------------------------------------------------------------------
*/

if ($password !== $confirmPassword) {

    header(
        "Location: reset_password.php?token=" .
        urlencode($token) .
        "&error=" .
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
        "Location: reset_password.php?token=" .
        urlencode($token) .
        "&error=" .
        urlencode(
            "Password must contain at least 8 characters."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| HASH TOKEN
|--------------------------------------------------------------------------
*/

$tokenHash = hash(
    'sha256',
    $token
);


/*
|--------------------------------------------------------------------------
| FIND VALID USER
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM users
    WHERE reset_token_hash = ?
      AND reset_expires_at IS NOT NULL
      AND reset_expires_at > NOW()
    LIMIT 1
");

$stmt->execute([$tokenHash]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$user) {

    header(
        "Location: login.php?error=" .
        urlencode(
            "This password reset link is invalid or has expired."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| HASH NEW PASSWORD
|--------------------------------------------------------------------------
*/

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);


/*
|--------------------------------------------------------------------------
| UPDATE PASSWORD
|--------------------------------------------------------------------------
|
| The reset token is immediately destroyed after use.
|
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    UPDATE users
    SET
        password = ?,
        reset_token_hash = NULL,
        reset_expires_at = NULL
    WHERE id = ?
");

$stmt->execute([
    $hashedPassword,
    $user['id']
]);


/*
|--------------------------------------------------------------------------
| SUCCESS
|--------------------------------------------------------------------------
*/

header(
    "Location: login.php?success=" .
    urlencode(
        "Your password has been reset successfully. " .
        "You can now log in with your new password."
    )
);

exit;