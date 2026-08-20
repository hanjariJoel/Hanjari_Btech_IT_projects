<?php

require "../config/database.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: forgot_password.php");

    exit;
}


$email = trim($_POST['email'] ?? '');


if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header(
        "Location: forgot_password.php?error=" .
        urlencode("Please enter a valid email address.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| FIND USER
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        id,
        email,
        role,
        status
    FROM users
    WHERE email = ?
    LIMIT 1
");

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| SECURITY
|--------------------------------------------------------------------------
|
| We deliberately use the same message whether or not
| the email exists.
|
|--------------------------------------------------------------------------
*/

$genericMessage =
    "If an account exists for that email address, " .
    "a password reset link has been generated.";


/*
|--------------------------------------------------------------------------
| ACCOUNT NOT FOUND
|--------------------------------------------------------------------------
*/

if (!$user) {

    header(
        "Location: forgot_password.php?message=" .
        urlencode($genericMessage)
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| ONLY ACTIVE / APPROVED USERS
|--------------------------------------------------------------------------
*/

if (
    $user['status'] !== 'Approved'
) {

    header(
        "Location: forgot_password.php?message=" .
        urlencode($genericMessage)
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| GENERATE SECURE TOKEN
|--------------------------------------------------------------------------
*/

$token = bin2hex(
    random_bytes(32)
);


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
| EXPIRATION
|--------------------------------------------------------------------------
|
| Token expires after 30 minutes.
|
|--------------------------------------------------------------------------
*/

$expiresAt = date(
    'Y-m-d H:i:s',
    time() + (30 * 60)
);


/*
|--------------------------------------------------------------------------
| SAVE TOKEN
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    UPDATE users
    SET
        reset_token_hash = ?,
        reset_expires_at = ?
    WHERE id = ?
");

$stmt->execute([
    $tokenHash,
    $expiresAt,
    $user['id']
]);


/*
|--------------------------------------------------------------------------
| DEVELOPMENT RESET LINK
|--------------------------------------------------------------------------
|
| IMPORTANT:
|
| This is for our XAMPP development environment.
|
| In production this link should be sent through email
| instead of displaying it on the screen.
|--------------------------------------------------------------------------
*/

$resetLink =
    "http://" .
    $_SERVER['HTTP_HOST'] .
    dirname($_SERVER['PHP_SELF']) .
    "/reset_password.php?token=" .
    urlencode($token);


/*
|--------------------------------------------------------------------------
| DISPLAY DEVELOPMENT LINK
|--------------------------------------------------------------------------
*/

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Password Reset</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="../assets/css/login.css"
    >

</head>


<body class="login-page">


<div class="login-container">


    <div class="login-icon">

        <i class="fa-solid fa-circle-check"></i>

    </div>


    <h1>
        Reset Link Generated
    </h1>


    <p class="login-subtitle">

        Development mode is active.

    </p>


    <div
        style="
            background:#FFF7CC;
            border:1px solid #FFD700;
            border-radius:10px;
            padding:15px;
            margin-bottom:20px;
            font-size:.85rem;
        "
    >

        <strong>
            Development Only
        </strong>

        <br><br>

        In the live system this link would be
        sent to the user's registered email.

    </div>


    <a
        href="<?= htmlspecialchars($resetLink); ?>"
        class="login-button"
        style="
            text-decoration:none;
            display:flex;
        "
    >

        <i class="fa-solid fa-key"></i>

        Continue to Reset Password

    </a>


    <div class="login-footer">

        Token expires in
        <strong>30 minutes.</strong>

    </div>


</div>


</body>

</html>