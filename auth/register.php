<?php
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Hanjari's Music House</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="../assets/css/registration.css"
    >

</head>

<body class="registration-page">

<div class="registration-container">

    <div class="registration-header">

        <div class="registration-icon">
            <i class="fa-solid fa-user-plus"></i>
        </div>

        <h1>Storekeeper Registration</h1>

        <p>
            Create an account to request access to
            Hanjari's Music House Stock Maintenance System.
        </p>

    </div>


    <?php if ($error !== ''): ?>

        <div class="registration-alert error">

            <i class="fa-solid fa-circle-exclamation"></i>

            <span>
                <?= htmlspecialchars($error); ?>
            </span>

        </div>

    <?php endif; ?>


    <?php if ($success !== ''): ?>

        <div class="registration-alert success">

            <i class="fa-solid fa-circle-check"></i>

            <span>
                <?= htmlspecialchars($success); ?>
            </span>

        </div>

    <?php endif; ?>


    <form
        action="save_registration.php"
        method="POST"
        autocomplete="off"
        class="registration-form"
    >

        <!-- FULL NAME -->

        <div class="form-group">

            <label for="full_name">
                <i class="fa-solid fa-user"></i>
                Full Name
            </label>

            <input
                type="text"
                id="full_name"
                name="full_name"
                placeholder="Enter your full name"
                maxlength="100"
                required
            >

        </div>


        <!-- USERNAME -->

        <div class="form-group">

            <label for="username">
                <i class="fa-solid fa-at"></i>
                Username
            </label>

            <input
                type="text"
                id="username"
                name="username"
                placeholder="Choose a username"
                maxlength="50"
                required
            >

        </div>


        <!-- EMAIL -->

        <div class="form-group">

            <label for="email">
                <i class="fa-solid fa-envelope"></i>
                Email Address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email address"
                maxlength="100"
                required
            >

        </div>


        <!-- PHONE -->

        <div class="form-group">

            <label for="phone">
                <i class="fa-solid fa-phone"></i>
                Phone Number
            </label>

            <input
                type="text"
                id="phone"
                name="phone"
                placeholder="+254 7XX XXX XXX"
                maxlength="20"
            >

        </div>


        <!-- PASSWORD -->

        <div class="form-group">

            <label for="password">
                <i class="fa-solid fa-lock"></i>
                Password
            </label>

            <div class="password-wrapper">

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Create a password"
                    required
                >

                <button
                    type="button"
                    class="password-toggle"
                    id="togglePassword"
                    aria-label="Show password"
                >
                    <i class="fa-solid fa-eye"></i>
                </button>

            </div>

        </div>


        <!-- CONFIRM PASSWORD -->

        <div class="form-group">

            <label for="confirm_password">
                <i class="fa-solid fa-lock"></i>
                Confirm Password
            </label>

            <div class="password-wrapper">

                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Confirm your password"
                    required
                >

                <button
                    type="button"
                    class="password-toggle"
                    id="toggleConfirmPassword"
                    aria-label="Show password"
                >
                    <i class="fa-solid fa-eye"></i>
                </button>

            </div>

        </div>


        <!-- ROLE -->

        <div class="role-info">

            <i class="fa-solid fa-store"></i>

            <div>

                <strong>Account Type</strong>

                <span>Storekeeper</span>

                <small>
                    Storekeeper accounts require administrator approval.
                </small>

            </div>

        </div>


        <!-- SUBMIT -->

        <button
            type="submit"
            class="register-button"
        >

            <i class="fa-solid fa-user-plus"></i>

            Submit Registration

        </button>


        <!-- LOGIN LINK -->

        <div class="login-link">

            Already have an account?

            <a href="login.php">
                Login here
            </a>

        </div>

    </form>


    <div class="registration-footer">

        <strong>Hanjari's Music House</strong>

        <br>

        Stock Maintenance System Version 1.0

        <br><br>

        &copy; <?= date('Y'); ?> All Rights Reserved.

    </div>

</div>


<script>

function togglePasswordVisibility(buttonId, inputId)
{
    const button = document.getElementById(buttonId);
    const input = document.getElementById(inputId);

    button.addEventListener("click", function ()
    {
        const isPassword = input.type === "password";

        input.type = isPassword ? "text" : "password";

        this.innerHTML = isPassword
            ? '<i class="fa-solid fa-eye-slash"></i>'
            : '<i class="fa-solid fa-eye"></i>';

        this.setAttribute(
            "aria-label",
            isPassword ? "Hide password" : "Show password"
        );
    });
}

togglePasswordVisibility(
    "togglePassword",
    "password"
);

togglePasswordVisibility(
    "toggleConfirmPassword",
    "confirm_password"
);

</script>

</body>

</html>