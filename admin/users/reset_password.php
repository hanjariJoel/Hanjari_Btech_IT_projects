<?php

require "../../includes/session.php";
require "../../config/database.php";

if ($_SESSION['role'] !== 'Administrator') {
    header("Location: ../../dashboard/dashboard.php");
    exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php?error=" . urlencode("Invalid user."));
    exit();
}

$stmt = $pdo->prepare("
    SELECT id, full_name, username, role
    FROM users
    WHERE id = ?
");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: index.php?error=" . urlencode("User not found."));
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (strlen($password) < 8) {
        $errors[] = "Password must contain at least 8 characters.";
    }

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $update = $pdo->prepare("
            UPDATE users
            SET password = ?
            WHERE id = ?
        ");

        $update->execute([
            $hashedPassword,
            $id
        ]);

        header("Location: index.php?success=" . urlencode("Password reset successfully."));
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
                    <i class="fa-solid fa-key"></i>
                    Reset Password
                </h2>

                <p class="text-muted">
                    Set a new password for this account.
                </p>
            </div>

            <a href="index.php" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>

        </div>

        <?php if (!empty($errors)): ?>

            <div class="alert alert-danger">

                <ul class="mb-0">

                    <?php foreach ($errors as $error): ?>

                        <li><?= htmlspecialchars($error); ?></li>

                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>

        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    <i class="fa-solid fa-user-lock"></i>
                    <?= htmlspecialchars($user['full_name']); ?>
                </h5>

            </div>

            <div class="card-body">

                <div class="alert alert-info">

                    <strong>Username:</strong>
                    <?= htmlspecialchars($user['username']); ?>

                    <br>

                    <strong>Role:</strong>
                    <?= htmlspecialchars($user['role']); ?>

                </div>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            New Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            minlength="8"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            name="confirm_password"
                            class="form-control"
                            minlength="8"
                            required
                        >

                    </div>

                    <button type="submit" class="btn btn-warning">

                        <i class="fa-solid fa-key"></i>
                        Reset Password

                    </button>

                    <a href="index.php" class="btn btn-secondary">
                        Cancel
                    </a>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include "../../includes/footer.php"; ?>