<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

/* -------------------------------------------------------
   Logged-in User
------------------------------------------------------- */

$id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
SELECT *
FROM users
WHERE id = ?
");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

/* -------------------------------------------------------
   Dashboard Statistics
------------------------------------------------------- */

$totalInstruments = $pdo->query("
SELECT COUNT(*)
FROM instruments
")->fetchColumn();

$totalCategories = $pdo->query("
SELECT COUNT(*)
FROM categories
")->fetchColumn();

$totalSuppliers = $pdo->query("
SELECT COUNT(*)
FROM suppliers
")->fetchColumn();

$totalTransactions = $pdo->query("
SELECT COUNT(*)
FROM stock_transactions
")->fetchColumn();

?>

<div class="wrapper">

    <?php include "../includes/sidebar.php"; ?>

    <div class="main-content">

        <?php include "../includes/navbar.php"; ?>

        <!-- ============================= -->
        <!-- Page Title -->
        <!-- ============================= -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>

                <i class="fa-solid fa-user"></i>

                My Profile

            </h2>

        </div>

        <!-- ============================= -->
        <!-- Welcome Card -->
        <!-- ============================= -->

        <div class="alert alert-primary shadow-sm">

            <h4>

                Welcome,

                <?= htmlspecialchars($user['full_name']); ?>

                👋

            </h4>

            <p class="mb-0">

                Manage your personal information and account settings.

            </p>

        </div>

        <!-- ============================= -->
        <!-- Profile Section -->
        <!-- ============================= -->

        <div class="row">

            <!-- LEFT COLUMN -->

            <div class="col-lg-4 mb-4">

                <div class="card shadow border-0">

                    <div class="card-body text-center">

                        <div class="profile-avatar">

                            <?= strtoupper(substr($user['full_name'],0,1)); ?>

                        </div>

                        <h3 class="mt-3">

                            <?= htmlspecialchars($user['full_name']); ?>

                        </h3>

                        <p class="text-muted">

                            <?= htmlspecialchars($user['role']); ?>

                        </p>

                        <hr>

                        <a
                        href="edit.php"
                        class="btn btn-primary w-100 mb-2">

                            <i class="fa-solid fa-user-pen"></i>

                            Edit Profile

                        </a>

                        <a
                        href="change_password.php"
                        class="btn btn-warning w-100">

                            <i class="fa-solid fa-key"></i>

                            Change Password

                        </a>

                    </div>

                </div>

            </div>

            <!-- RIGHT COLUMN -->

            <div class="col-lg-8 mb-4">

                <div class="card shadow border-0">

                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">

                            Account Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless">

                            <tr>

                                <th width="35%">

                                    <i class="fa-solid fa-user"></i>

                                    Full Name

                                </th>

                                <td>

                                    <?= htmlspecialchars($user['full_name']); ?>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    <i class="fa-solid fa-at"></i>

                                    Username

                                </th>

                                <td>

                                    <?= htmlspecialchars($user['username']); ?>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    <i class="fa-solid fa-envelope"></i>

                                    Email

                                </th>

                                <td>

                                    <?= htmlspecialchars($user['email']); ?>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    <i class="fa-solid fa-phone"></i>

                                    Phone

                                </th>

                                <td>

                                    <?= !empty($user['phone'])
                                    ? htmlspecialchars($user['phone'])
                                    : "Not Available"; ?>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    <i class="fa-solid fa-user-shield"></i>

                                    Role

                                </th>

                                <td>

                                    <?= htmlspecialchars($user['role']); ?>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    <i class="fa-solid fa-calendar"></i>

                                    Member Since

                                </th>

                                <td>

                                    <?= date("F Y", strtotime($user['created_at'])); ?>

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <!-- ============================= -->
        <!-- Statistics -->
        <!-- ============================= -->

        <div class="row mb-4">

            <div class="col-md-3">

                <div class="card-box text-center">

                    <i class="fa-solid fa-guitar fa-2x mb-2 text-primary"></i>

                    <h6>Instruments</h6>

                    <h2><?= $totalInstruments; ?></h2>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card-box text-center">

                    <i class="fa-solid fa-folder fa-2x mb-2 text-warning"></i>

                    <h6>Categories</h6>

                    <h2><?= $totalCategories; ?></h2>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card-box text-center">

                    <i class="fa-solid fa-truck fa-2x mb-2 text-success"></i>

                    <h6>Suppliers</h6>

                    <h2><?= $totalSuppliers; ?></h2>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card-box text-center">

                    <i class="fa-solid fa-boxes-stacked fa-2x mb-2 text-danger"></i>

                    <h6>Transactions</h6>

                    <h2><?= $totalTransactions; ?></h2>

                </div>

            </div>

        </div>

        <!-- ============================= -->
        <!-- System Information -->
        <!-- ============================= -->

        <div class="card shadow border-0">

            <div class="card-header bg-dark text-white">

                <h5 class="mb-0">

                    System Information

                </h5>

            </div>

            <div class="card-body">

                <table class="table table-borderless">

                    <tr>

                        <th width="30%">Application</th>

                        <td>Hanjari's Music House Stock Maintenance System</td>

                    </tr>

                    <tr>

                        <th>Version</th>

                        <td>1.0</td>

                    </tr>

                    <tr>

                        <th>Database</th>

                        <td>MySQL</td>

                    </tr>

                    <tr>

                        <th>Framework</th>

                        <td>Bootstrap 5</td>

                    </tr>

                    <tr>

                        <th>Developed By</th>

                        <td><?= htmlspecialchars($user['full_name']); ?></td>

                    </tr>

                    <tr>

                        <th>Institution</th>

                        <td>Technical University of Kenya</td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>