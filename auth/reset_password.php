<?php

require "../config/database.php";


$token = $_GET['token'] ?? '';


if ($token === '') {

    header(
        "Location: login.php?error=" .
        urlencode("Invalid password reset link.")
    );

    exit;
}


$tokenHash = hash(
    'sha256',
    $token
);


/*
|--------------------------------------------------------------------------
| FIND VALID TOKEN
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        id
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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Reset Password | Hanjari's Music House
    </title>


    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet"
    >


    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    >


    <link
        rel="stylesheet"
        href="../assets/css/login.css"
    >

</head>


<body class="login-page">


<div class="login-container">


    <div class="login-icon">

        <i class="fa-solid fa-lock"></i>

    </div>


    <h1>
        Reset Password
    </h1>


    <div class="login-ornament">

        &diams; &diams; &diams;

    </div>


    <p class="login-subtitle">

        Create a new password for your account.

    </p>


    <form
        action="update_password.php"
        method="POST"
    >


        <input
            type="hidden"
            name="token"
            value="<?= htmlspecialchars($token); ?>"
        >


        <div class="login-field">

            <div class="field-icon">

                <i class="fa-solid fa-lock"></i>

            </div>


            <input
                type="password"
                name="password"
                placeholder="New password"
                minlength="8"
                required
            >

        </div>


        <div class="login-field">

            <div class="field-icon">

                <i class="fa-solid fa-lock"></i>

            </div>


            <input
                type="password"
                name="confirm_password"
                placeholder="Confirm new password"
                minlength="8"
                required
            >

        </div>


        <button
            type="submit"
            class="login-button"
        >

            <i class="fa-solid fa-key"></i>

            Update Password

        </button>


    </form>


    <div class="login-footer">

        Password must contain at least
        <strong>8 characters.</strong>

    </div>


</div>


</body>

</html>