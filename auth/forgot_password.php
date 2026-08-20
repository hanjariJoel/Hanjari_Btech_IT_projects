<?php

$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';

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
        Forgot Password | Hanjari's Music House
    </title>

    <!-- Google Fonts -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet"
    >

    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    >

    <!-- Login styling -->

    <link
        rel="stylesheet"
        href="../assets/css/login.css"
    >

</head>


<body class="login-page">


<div class="login-container">


    <!-- ICON -->

    <div class="login-icon">

        <i class="fa-solid fa-key"></i>

    </div>


    <!-- TITLE -->

    <h1>
        Forgot Password?
    </h1>


    <div class="login-ornament">

        &diams; &diams; &diams;

    </div>


    <p class="login-subtitle">

        Enter your registered email address
        and we'll help you reset your password.

    </p>


    <!-- ERROR -->

    <?php if ($error !== ''): ?>

        <div class="login-alert">

            <i class="fa-solid fa-circle-exclamation"></i>

            <?= htmlspecialchars($error); ?>

        </div>

    <?php endif; ?>


    <!-- SUCCESS -->

    <?php if ($message !== ''): ?>

        <div
            class="login-alert"
            style="
                background:#F0FDF4;
                color:#166534;
                border-color:#BBF7D0;
                border-left-color:#16A34A;
            "
        >

            <i class="fa-solid fa-circle-check"></i>

            <?= htmlspecialchars($message); ?>

        </div>

    <?php endif; ?>


    <!-- FORM -->

    <form
        action="send_reset.php"
        method="POST"
        autocomplete="off"
    >


        <div class="login-field">

            <div class="field-icon">

                <i class="fa-solid fa-envelope"></i>

            </div>


            <input
                type="email"
                name="email"
                placeholder="Enter your email address"
                autocomplete="email"
                required
            >

        </div>


        <button
            type="submit"
            class="login-button"
        >

            <i class="fa-solid fa-paper-plane"></i>

            Send Reset Link

        </button>


    </form>


    <!-- BACK TO LOGIN -->

    <div
        class="login-footer"
        style="border-top:none;"
    >

        <a href="login.php">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Login

        </a>

    </div>


    <!-- FOOTER -->

    <div class="login-footer">

        <strong>
            Hanjari's Music House
        </strong>

        <br>

        Stock Maintenance System Version 1.0

        <br><br>

        &copy; <?= date('Y'); ?> All Rights Reserved.

    </div>


</div>


</body>

</html>