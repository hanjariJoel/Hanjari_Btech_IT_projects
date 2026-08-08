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
    SELECT *
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

    $full_name = trim($_POST['full_name'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');

    if ($full_name === '') {
        $errors[] = "Full name is required.";
    }

    if ($username === '') {
        $errors[] = "Username is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    $check = $pdo->prepare("
        SELECT id
        FROM users
        WHERE (username = ? OR email = ?)
        AND id != ?
    ");

    $check->execute([
        $username,
        $email,
        $id
    ]);

    if ($check->fetch()) {
        $errors[] = "Username or email already belongs to another user.";
    }

    if (empty($errors)) {

        $update = $pdo->prepare("
            UPDATE users
            SET
                full_name = ?,
                username = ?,
                email = ?,
                phone = ?
            WHERE id = ?
        ");

        $update->execute([
            $full_name,
            $username,
            $email,
            $phone !== '' ? $phone : null,
            $id
        ]);

        header("Location: index.php?success=" . urlencode("User updated successfully."));
        exit();
    }

    $user['full_name'] = $full_name;
    $user['username'] = $username;
    $user['email'] = $email;
    $user['phone'] = $phone;
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
                    <i class="fa-solid fa-user-pen"></i>
                    Edit User
                </h2>

                <p class="text-muted">
                    Update account information.
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
                    Account Information
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
                                value="<?= htmlspecialchars($user['full_name']); ?>"
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
                                value="<?= htmlspecialchars($user['username']); ?>"
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
                                value="<?= htmlspecialchars($user['email']); ?>"
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
                                value="<?= htmlspecialchars($user['phone'] ?? ''); ?>"
                            >

                        </div>

                    </div>

                    <div class="mt-3">

                        <span class="badge <?= $user['role'] === 'Administrator' ? 'bg-warning' : 'bg-success'; ?>">

                            <?= htmlspecialchars($user['role']); ?>

                        </span>

                        <?php if ($user['role'] === 'Administrator'): ?>

                            <p class="text-muted mt-2 mb-0">
                                Administrator role cannot be changed from this page.
                            </p>

                        <?php endif; ?>

                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-success">

                            <i class="fa-solid fa-floppy-disk"></i>
                            Save Changes

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