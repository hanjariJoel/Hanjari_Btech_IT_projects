<?php

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Hanjari's Music House | Login</title>

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
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    >

    <!-- Login CSS -->
    <link
        rel="stylesheet"
        href="../assets/css/login.css"
    >

</head>


<body class="login-page">


<div class="login-wrapper">


    <!-- =====================================================
         LEFT BRANDING SECTION
    ====================================================== -->

    <section class="login-brand">

        <div class="brand-overlay"></div>

        <div class="brand-content">

            <div class="brand-logo">

                <div class="brand-logo-circle">

                    <span>H</span>

                </div>

            </div>


            <h1>
                HANJARI'S
                <br>
                <span>MUSIC HOUSE</span>
            </h1>


            <div class="brand-divider">

                <span></span>

                <i class="fa-solid fa-music"></i>

                <span></span>

            </div>


            <p class="brand-system">
                Stock Maintenance System
            </p>


            <div class="music-symbols">

                <i class="fa-solid fa-music"></i>

                <i class="fa-solid fa-music"></i>

                <i class="fa-solid fa-music"></i>

            </div>

        </div>

    </section>



    <!-- =====================================================
         RIGHT LOGIN SECTION
    ====================================================== -->

    <section class="login-panel">


        <div class="login-content">


            <div class="welcome-section">

                <h2>
                    Welcome Back!
                </h2>

                <p>
                    Sign in to continue to your account.
                </p>

            </div>



            <?php if ($error !== ''): ?>

                <div class="login-alert">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <span>
                        <?= htmlspecialchars($error); ?>
                    </span>

                </div>

            <?php endif; ?>


            <?php if ($success !== ''): ?>

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

        <?= htmlspecialchars($success); ?>

    </div>

<?php endif; ?>


            <!-- LOGIN FORM -->

            <form
                action="authenticate.php"
                method="POST"
                class="login-form"
                autocomplete="off"
            >


                <!-- USERNAME -->

                <div class="form-field">

                    <label for="username">
                        Username
                    </label>


                    <div class="input-wrapper">

                        <i class="fa-regular fa-user input-icon"></i>


                        <input
                            id="username"
                            type="text"
                            name="username"
                            placeholder="Enter your username"
                            autocomplete="username"
                            required
                        >

                    </div>

                </div>



                <!-- PASSWORD -->

                <div class="form-field">

                    <label for="password">
                        Password
                    </label>


                    <div class="input-wrapper">

                        <i class="fa-solid fa-lock input-icon"></i>


                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >


                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Show password"
                        >

                            <i class="fa-regular fa-eye"></i>

                        </button>

                    </div>

                </div>



                <!-- REMEMBER ME -->

                <div class="form-options">


                    <label class="remember-me">

                        <input
                            type="checkbox"
                            name="remember"
                        >

                        <span>
                            Remember me
                        </span>

                    </label>


                    <a
                        href="forgot_password.php"
                        class="forgot-password"
                    >
                        Forgot password?
                    </a>


                </div>



                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    class="login-button"
                >

                    <i class="fa-solid fa-right-to-bracket"></i>

                    LOGIN

                </button>


            </form>
            
            <div class="register-link">

    <span>Don't have a storekeeper account?</span>

    <a href="register.php">
        <i class="fa-solid fa-user-plus"></i>
        Register as Storekeeper
    </a>

</div>


            <!-- DIVIDER -->

            <div class="login-divider">

                <span></span>

                <strong>or</strong>

                <span></span>

            </div>



            



            <!-- HELP -->

            <div class="login-help">

                <i class="fa-solid fa-headset"></i>

                <span>
                    Need assistance? Contact the System Administrator.
                </span>

            </div>


        </div>


    </section>


</div>



<!-- =====================================================
     CONTACT INFORMATION
====================================================== -->

<div class="contact-bar">


    <div class="contact-item">

        <div class="contact-icon">

            <i class="fa-solid fa-phone"></i>

        </div>

        <div>

            <strong>Phone</strong>

            <span>
                +254 740 704 619
            </span>

        </div>

    </div>



    <div class="contact-item">

        <div class="contact-icon">

            <i class="fa-solid fa-envelope"></i>

        </div>

        <div>

            <strong>Email</strong>

            <span>
                support@hanjarimusic.co.ke
            </span>

        </div>

    </div>



    <div class="contact-item">

        <div class="contact-icon">

            <i class="fa-solid fa-location-dot"></i>

        </div>

        <div>

            <strong>Address</strong>

            <span>
                Moi Avenue, Nairobi, Kenya
            </span>

        </div>

    </div>



    <div class="contact-item">

        <div class="contact-icon">

            <i class="fa-regular fa-clock"></i>

        </div>

        <div>

            <strong>Business Hours</strong>

            <span>
                Mon - Sat: 8:00 AM - 6:00 PM
            </span>

        </div>

    </div>


</div>



<!-- =====================================================
     FOOTER
====================================================== -->

<footer class="login-footer">

    <div>

        <strong>
            Hanjari's Music House
        </strong>

        <span>
            © <?= date('Y'); ?> Hanjari's Music House. All Rights Reserved.
        </span>

    </div>


    <div class="social-icons">

        <a href="#">
            <i class="fa-brands fa-facebook-f"></i>
        </a>

        <a href="#">
            <i class="fa-brands fa-instagram"></i>
        </a>

        <a href="#">
            <i class="fa-brands fa-whatsapp"></i>
        </a>

        <a href="#">
            <i class="fa-solid fa-music"></i>
        </a>

    </div>

</footer>



<!-- =====================================================
     PASSWORD TOGGLE
====================================================== -->

<script>

const togglePassword =
    document.getElementById("togglePassword");

const password =
    document.getElementById("password");


togglePassword.addEventListener("click", function () {

    const isPassword =
        password.type === "password";


    password.type =
        isPassword ? "text" : "password";


    this.innerHTML =
        isPassword
        ? '<i class="fa-regular fa-eye-slash"></i>'
        : '<i class="fa-regular fa-eye"></i>';


    this.setAttribute(
        "aria-label",
        isPassword
            ? "Hide password"
            : "Show password"
    );

});

</script>


</body>
</html>