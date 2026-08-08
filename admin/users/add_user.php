<?php

require "../../includes/session.php";
require "../../config/database.php";

if ($_SESSION['role'] !== 'Administrator') {
    header("Location: ../../dashboard/dashboard.php");
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $password  = $_POST['password'] ?? '';
    $confirm   = $_POST['confirm_password'] ?? '';

    if ($full_name === '') {
        $errors[] = "Full name is required.";
    }

    if ($username === '') {
        $errors[] = "Username is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    if ($password === '') {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must contain at least 8 characters.";
    }

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {

        $check = $pdo->prepare("
            SELECT id
            FROM users
            WHERE username = ? OR email = ?
        ");

        $check->execute([$username, $email]);

        if ($check->fetch()) {
            $errors[] = "Username or email already exists.";
        }
    }

    if (empty($errors)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO users
            (
                full_name,
                username,
                email,
                phone,
                password,
                role
            )
            VALUES (?, ?, ?, ?, ?, 'Storekeeper')
        ");

        $stmt->execute([
            $full_name,
            $username,
            $email,
            $phone !== '' ? $phone : null,
            $hashedPassword
        ]);

        header("Location: index.php?success=" . urlencode("Storekeeper account created successfully."));
        exit();
    }
}

include "../../includes/header.php";
?>

<div class="wrapper">

    <?php include "../../includes/sidebar.php"; ?>

    <div class="main-content">

        <?php include "../../includes/navbar.php"; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2>
                    <i class="fa-solid fa-user-plus"></i>
                    Add Storekeeper
                </h2>

                <p class="text-muted">
                    Create a new storekeeper account.
                </p>
            </div>

            <a href="index.php" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>

        </div>

        <?php if (!empty($errors)): ?>

            <div class="alert alert-danger">

                <strong>
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Please correct the following:
                </strong>

                <ul class="mb-0 mt-2">

                    <?php foreach ($errors as $error): ?>

                        <li><?= htmlspecialchars($error); ?></li>

                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>

        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    <i class="fa-solid fa-user"></i>
                    Storekeeper Information
                </h5>

            </div>

            <div class="card-body">

                <form method="POST" autocomplete="off">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="full_name"
                                class="form-control"
                                value="<?= htmlspecialchars($_POST['full_name'] ?? ''); ?>"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                value="<?= htmlspecialchars($_POST['username'] ?? ''); ?>"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Phone
                            </label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                value="<?= htmlspecialchars($_POST['phone'] ?? ''); ?>"
                                placeholder="+254..."
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                minlength="8"
                                required
                            >

                            <small class="text-muted">
                                Minimum 8 characters.
                            </small>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <input
                                type="password"
                                name="confirm_password"
                                class="form-control"
                                minlength="8"
                                required
                            >

                        </div>

                    </div>

                    <div class="alert alert-info mt-3">

                        <i class="fa-solid fa-circle-info"></i>

                        New accounts created here are automatically assigned
                        the <strong>Storekeeper</strong> role.

                    </div>

                    <div class="d-flex gap-2 mt-4">

                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-user-plus"></i>
                            Create Account
                        </button>

                        <a href="index.php" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include "../../includes/footer.php"; ?>