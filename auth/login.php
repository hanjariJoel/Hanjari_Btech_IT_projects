<?php

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
        Hanjari's Music House | Login
    </title>

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
        <i class="fa-solid fa-music"></i>
    </div>

    <h1>
        Hanjari's Music House
    </h1>

    <div class="login-ornament">
        &diams; &diams; &diams;
    </div>

    <p>
        Stock Maintenance System
    </p>

    <?php if ($error !== ''): ?>

        <div class="login-alert">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?= htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>

    <form
        action="authenticate.php"
        method="POST"
        autocomplete="off"
    >

        <div class="input-group">

            <label for="username">
                <i class="fa-solid fa-user"></i>
            </label>

            <input
                id="username"
                type="text"
                name="username"
                placeholder="Username"
                autocomplete="username"
                required
            >

        </div>

        <div class="input-group">

            <label for="password">
                <i class="fa-solid fa-lock"></i>
            </label>

            <input
                id="password"
                type="password"
                name="password"
                placeholder="Password"
                autocomplete="current-password"
                required
            >

            <button
                type="button"
                class="toggle-password"
                id="togglePassword"
                aria-label="Show password"
            >
                <i class="fa-solid fa-eye"></i>
            </button>

        </div>

        <label class="remember-me">

            <input
                type="checkbox"
                name="remember"
            >

            <span>Remember Me</span>

        </label>

        <button
            type="submit"
            class="login-button"
        >
            <i class="fa-solid fa-right-to-bracket"></i>
            Login
        </button>

    </form>

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

<script>

const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");

togglePassword.addEventListener("click", function () {

    const isPassword = password.type === "password";

    password.type = isPassword ? "text" : "password";

    this.innerHTML = isPassword
        ? '<i class="fa-solid fa-eye-slash"></i>'
        : '<i class="fa-solid fa-eye"></i>';

    this.setAttribute(
        "aria-label",
        isPassword ? "Hide password" : "Show password"
    );

});

</script>

</body>
</html>