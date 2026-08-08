<?php

declare(strict_types=1);

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

$userId = (int) $_SESSION['user_id'];

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

?>

<div class="wrapper">

    <?php include "../includes/sidebar.php"; ?>

    <div class="main-content">

        <?php include "../includes/navbar.php"; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="mb-0">
                <i class="fa-solid fa-key"></i>
                Change Password
            </h2>

            <a href="index.php" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Profile
            </a>

        </div>

        <?php if ($error): ?>

            <div class="alert alert-danger alert-dismissible fade show">

                <i class="fa-solid fa-circle-exclamation"></i>

                <?= htmlspecialchars(urldecode($error)); ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        <?php endif; ?>

        <?php if ($success): ?>

            <div class="alert alert-success alert-dismissible fade show">

                <i class="fa-solid fa-circle-check"></i>

                <?= htmlspecialchars(urldecode($success)); ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        <?php endif; ?>

        <div class="row justify-content-center">

            <div class="col-lg-7 col-md-9">

                <div class="card shadow">

                    <div class="card-header">

                        <h5 class="mb-0">
                            <i class="fa-solid fa-lock"></i>
                            Password Security
                        </h5>

                    </div>

                    <div class="card-body p-4">

                        <div class="alert alert-info">

                            <i class="fa-solid fa-shield-halved"></i>

                            Choose a strong password containing at least
                            <strong>8 characters</strong>, including uppercase,
                            lowercase, numbers, and special characters.

                        </div>

                        <form
                            action="update_password.php"
                            method="POST"
                            id="changePasswordForm"
                            novalidate>

                            <input
                                type="hidden"
                                name="user_id"
                                value="<?= $userId; ?>">

                            <div class="mb-4">

                                <label
                                    for="current_password"
                                    class="form-label">

                                    Current Password

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>

                                    <input
                                        type="password"
                                        class="form-control"
                                        id="current_password"
                                        name="current_password"
                                        placeholder="Enter your current password"
                                        autocomplete="current-password"
                                        required>

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary toggle-password"
                                        data-target="current_password">

                                        <i class="fa-solid fa-eye"></i>

                                    </button>

                                </div>

                            </div>

                            <div class="mb-3">

                                <label
                                    for="new_password"
                                    class="form-label">

                                    New Password

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fa-solid fa-key"></i>
                                    </span>

                                    <input
                                        type="password"
                                        class="form-control"
                                        id="new_password"
                                        name="new_password"
                                        placeholder="Enter your new password"
                                        autocomplete="new-password"
                                        minlength="8"
                                        required>

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary toggle-password"
                                        data-target="new_password">

                                        <i class="fa-solid fa-eye"></i>

                                    </button>

                                </div>

                                <div class="mt-2">

                                    <div class="progress" style="height:6px;">

                                        <div
                                            id="passwordStrength"
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width:0%;"
                                            aria-valuenow="0"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>

                                    </div>

                                    <small
                                        id="passwordStrengthText"
                                        class="text-muted">

                                        Password strength

                                    </small>

                                </div>

                            </div>

                            <div class="mb-4">

                                <label
                                    for="confirm_password"
                                    class="form-label">

                                    Confirm New Password

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>

                                    <input
                                        type="password"
                                        class="form-control"
                                        id="confirm_password"
                                        name="confirm_password"
                                        placeholder="Confirm your new password"
                                        autocomplete="new-password"
                                        minlength="8"
                                        required>

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary toggle-password"
                                        data-target="confirm_password">

                                        <i class="fa-solid fa-eye"></i>

                                    </button>

                                </div>

                                <small
                                    id="passwordMatch"
                                    class="form-text">
                                </small>

                            </div>

                            <hr>

                            <div class="d-flex justify-content-end gap-2">

                                <a
                                    href="index.php"
                                    class="btn btn-secondary">

                                    <i class="fa-solid fa-xmark"></i>
                                    Cancel

                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    id="updatePasswordButton">

                                    <i class="fa-solid fa-key"></i>
                                    Update Password

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>

<script>

document.querySelectorAll(".toggle-password").forEach(button => {

    button.addEventListener("click", function () {

        const target = document.getElementById(
            this.dataset.target
        );

        const icon = this.querySelector("i");

        if (target.type === "password") {

            target.type = "text";

            icon.classList.remove("fa-eye");

            icon.classList.add("fa-eye-slash");

        } else {

            target.type = "password";

            icon.classList.remove("fa-eye-slash");

            icon.classList.add("fa-eye");

        }

    });

});


const newPassword = document.getElementById("new_password");

const confirmPassword = document.getElementById("confirm_password");

const strengthBar = document.getElementById("passwordStrength");

const strengthText = document.getElementById("passwordStrengthText");

const passwordMatch = document.getElementById("passwordMatch");


newPassword.addEventListener("input", function () {

    const password = this.value;

    let score = 0;

    if (password.length >= 8) score++;

    if (/[A-Z]/.test(password)) score++;

    if (/[a-z]/.test(password)) score++;

    if (/[0-9]/.test(password)) score++;

    if (/[^A-Za-z0-9]/.test(password)) score++;

    const levels = {

        0: ["0%", "Password strength", ""],
        1: ["20%", "Very Weak", "bg-danger"],
        2: ["40%", "Weak", "bg-danger"],
        3: ["60%", "Fair", "bg-warning"],
        4: ["80%", "Strong", "bg-success"],
        5: ["100%", "Very Strong", "bg-success"]

    };

    const level = levels[score];

    strengthBar.style.width = level[0];

    strengthBar.className = "progress-bar";

    if (level[2]) {
        strengthBar.classList.add(level[2]);
    }

    strengthText.textContent = level[1];

    checkPasswordMatch();

});


confirmPassword.addEventListener("input", checkPasswordMatch);


function checkPasswordMatch() {

    if (confirmPassword.value === "") {

        passwordMatch.textContent = "";

        confirmPassword.classList.remove(
            "is-valid",
            "is-invalid"
        );

        return;

    }

    if (newPassword.value === confirmPassword.value) {

        passwordMatch.textContent = "Passwords match.";

        passwordMatch.className =
            "form-text text-success";

        confirmPassword.classList.add("is-valid");

        confirmPassword.classList.remove("is-invalid");

    } else {

        passwordMatch.textContent =
            "Passwords do not match.";

        passwordMatch.className =
            "form-text text-danger";

        confirmPassword.classList.add("is-invalid");

        confirmPassword.classList.remove("is-valid");

    }

}


document.getElementById("changePasswordForm").addEventListener(
    "submit",
    function (event) {

        if (
            newPassword.value.length < 8 ||
            newPassword.value !== confirmPassword.value
        ) {

            event.preventDefault();

            alert(
                "Please enter a valid password and make sure both passwords match."
            );

        }

    }
);

</script>