<?php

require "../../config/auth.php";

requireRole("Administrator");

?>


<?php
/* ==========================================================
   HANJARI'S MUSIC HOUSE
   ADMIN - USER MANAGEMENT
   index.php
========================================================== */

require_once "../../includes/session.php";
require_once "../../config/database.php";

/* ----------------------------------------------------------
   ADMINISTRATOR ONLY
---------------------------------------------------------- */

if (
    !isset($_SESSION['role']) ||
    !in_array(
        strtolower(trim($_SESSION['role'])),
        ['admin', 'administrator'],
        true
    )
) {
    header("Location: ../../dashboard/dashboard.php");
    exit();
}

/* ----------------------------------------------------------
   FETCH USERS
---------------------------------------------------------- */

$stmt = $pdo->query("
    SELECT
        id,
        full_name,
        username,
        email,
        phone,
        role,
        created_at
    FROM users
    ORDER BY created_at DESC
");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalUsers = count($users);
$administrators = 0;
$storekeepers = 0;

foreach ($users as $user) {

    $role = strtolower(trim($user['role'] ?? ''));

    if (in_array($role, ['admin', 'administrator'], true)) {
        $administrators++;
    }

    if ($role === 'storekeeper') {
        $storekeepers++;
    }
}

include "../../includes/header.php";
?>

<div class="wrapper">

    <?php include "../../includes/sidebar.php"; ?>

    <div class="main-content">

        <?php include "../../includes/navbar.php"; ?>

        <!-- PAGE HEADER -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>
                <h2 class="page-title">
                    <i class="fa-solid fa-users-gear"></i>
                    User Management
                </h2>

                <p class="page-subtitle mb-0">
                    Manage administrators and storekeepers who have access to the system.
                </p>
            </div>

            <a href="add_user.php" class="btn btn-gold">
                <i class="fa-solid fa-user-plus"></i>
                Add User
            </a>

        </div>

        <!-- STATISTICS -->
        <div class="row g-4 mb-4">

            <div class="col-md-4">

                <div class="user-stat-card">

                    <div class="user-stat-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <div>
                        <span>Total Users</span>
                        <strong><?= $totalUsers ?></strong>
                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="user-stat-card">

                    <div class="user-stat-icon admin">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>

                    <div>
                        <span>Administrators</span>
                        <strong><?= $administrators ?></strong>
                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="user-stat-card">

                    <div class="user-stat-icon staff">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>

                    <div>
                        <span>Storekeepers</span>
                        <strong><?= $storekeepers ?></strong>
                    </div>

                </div>

            </div>

        </div>


        <!-- USER TABLE -->
        <div class="card user-management-card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <div>
                    <h5>
                        <i class="fa-solid fa-user-group me-2"></i>
                        System Users
                    </h5>

                    <small class="text-muted">
                        Registered personnel with access to the system
                    </small>
                </div>

                <span class="user-count">
                    <?= $totalUsers ?> User<?= $totalUsers == 1 ? '' : 's' ?>
                </span>

            </div>


            <div class="card-body p-0">

                <?php if (empty($users)): ?>

                    <div class="empty-users">

                        <div class="empty-users-icon">
                            <i class="fa-solid fa-users-slash"></i>
                        </div>

                        <h5>No users found</h5>

                        <p>
                            There are currently no registered users.
                        </p>

                        <a href="add_user.php" class="btn btn-gold">
                            <i class="fa-solid fa-user-plus"></i>
                            Add First User
                        </a>

                    </div>

                <?php else: ?>

                    <div class="table-responsive">

                        <table class="table user-table mb-0">

                            <thead>

                                <tr>

                                    <th>#</th>
                                    <th>User</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Created</th>
                                    <th class="text-center">Actions</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($users as $index => $user): ?>

                                    <?php
                                    $fullName = trim($user['full_name'] ?? '');
                                    $initial = $fullName !== ''
                                        ? strtoupper(substr($fullName, 0, 1))
                                        : '?';

                                    $role = strtolower(trim($user['role'] ?? ''));

                                    $isAdmin = in_array(
                                        $role,
                                        ['admin', 'administrator'],
                                        true
                                    );
                                    ?>

                                    <tr>

                                        <!-- NUMBER -->
                                        <td>
                                            <?= $index + 1 ?>
                                        </td>


                                        <!-- USER -->
                                        <td>

                                            <div class="user-profile-cell">

                                                <div class="user-avatar-small">
                                                    <?= htmlspecialchars($initial) ?>
                                                </div>

                                                <div>

                                                    <strong>
                                                        <?= htmlspecialchars($fullName) ?>
                                                    </strong>

                                                    <small>
                                                        System User
                                                    </small>

                                                </div>

                                            </div>

                                        </td>


                                        <!-- USERNAME -->
                                        <td>

                                            <span class="username-text">
                                                @<?= htmlspecialchars($user['username']) ?>
                                            </span>

                                        </td>


                                        <!-- EMAIL -->
                                        <td>
                                            <?= htmlspecialchars($user['email'] ?? 'Not provided') ?>
                                        </td>


                                        <!-- PHONE -->
                                        <td>

                                            <?php if (!empty($user['phone'])): ?>

                                                <?= htmlspecialchars($user['phone']) ?>

                                            <?php else: ?>

                                                <span class="text-muted">
                                                    Not provided
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- ROLE -->
                                        <td>

                                            <?php if ($isAdmin): ?>

                                                <span class="role-badge role-admin">
                                                    <i class="fa-solid fa-shield-halved"></i>
                                                    Administrator
                                                </span>

                                            <?php else: ?>

                                                <span class="role-badge role-storekeeper">
                                                    <i class="fa-solid fa-user-tie"></i>
                                                    Storekeeper
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- CREATED -->
                                        <td>

                                            <span class="created-date">

                                                <?= !empty($user['created_at'])
                                                    ? date(
                                                        "d M Y",
                                                        strtotime($user['created_at'])
                                                    )
                                                    : '—'
                                                ?>

                                            </span>

                                        </td>


                                        <!-- ACTIONS -->
                                        <td>

                                            <div class="user-actions">

                                                <a
                                                    href="edit.php?id=<?= (int)$user['id'] ?>"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Edit User">

                                                    <i class="fa-solid fa-pen"></i>

                                                </a>


                                                <?php if ((int)$user['id'] !== (int)$_SESSION['user_id']): ?>

                                                    <a
                                                        href="delete.php?id=<?= (int)$user['id'] ?>"
                                                        class="btn btn-sm btn-outline-danger delete-btn"
                                                        title="Delete User">

                                                        <i class="fa-solid fa-trash"></i>

                                                    </a>

                                                <?php else: ?>

                                                    <span
                                                        class="current-user-label"
                                                        title="You cannot delete your own account">

                                                        <i class="fa-solid fa-user-check"></i>

                                                    </span>

                                                <?php endif; ?>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php include "../../includes/footer.php"; ?>