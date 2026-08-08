<?php

require "../includes/session.php";
require "../config/database.php";
require "../config/functions.php";

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

$totalInstruments = countRecords($pdo, "instruments");
$totalCategories  = countRecords($pdo, "categories");
$totalSuppliers   = countRecords($pdo, "suppliers");
$lowStock         = getLowStockCount($pdo);
$activities       = getRecentActivities($pdo);

$totalTransactions = $pdo->query("
SELECT COUNT(*)
FROM stock_transactions
")->fetchColumn();

$todayTransactions = $pdo->query("
SELECT COUNT(*)
FROM stock_transactions
WHERE transaction_date = CURDATE()
")->fetchColumn();

include "../includes/header.php";

?>

<div class="wrapper">

    <?php include "../includes/sidebar.php"; ?>

    <div class="main-content">

        <?php include "../includes/navbar.php"; ?>

        <!-- Welcome -->

        <div class="alert alert-primary shadow-sm mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h4 class="mb-1">

                        <span id="greeting"></span>,

                        <?= htmlspecialchars($_SESSION['full_name']); ?>

                    </h4>

                    <p class="mb-0">

                        Welcome to Hanjari's Music House Stock Maintenance System.

                    </p>

                </div>

                <div class="text-end">

                    <small class="text-muted">

                        <i class="fa-solid fa-calendar-days"></i>

                        <span id="currentDate"></span>

                    </small>

                </div>

            </div>

        </div>

        <!-- Statistics -->

        <div class="row g-4 mb-4">

            <div class="col-lg-3 col-md-6">

                <div class="card-box">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6>Total Instruments</h6>

                            <h2><?= number_format($totalInstruments); ?></h2>

                        </div>

                        <i class="fa-solid fa-guitar fa-3x text-primary"></i>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="card-box">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6>Categories</h6>

                            <h2><?= number_format($totalCategories); ?></h2>

                        </div>

                        <i class="fa-solid fa-folder-tree fa-3x text-warning"></i>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="card-box">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6>Suppliers</h6>

                            <h2><?= number_format($totalSuppliers); ?></h2>

                        </div>

                        <i class="fa-solid fa-truck fa-3x text-success"></i>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="card-box">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6>Low Stock</h6>

                            <h2><?= number_format($lowStock); ?></h2>

                        </div>

                        <i class="fa-solid fa-triangle-exclamation fa-3x text-danger"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Secondary Cards -->

        <div class="row g-4 mb-4">

            <div class="col-md-6">

                <div class="card shadow-sm h-100">

                    <div class="card-header">

                        <h5>

                            <i class="fa-solid fa-chart-line"></i>

                            Inventory Summary

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless">

                            <tr>

                                <th>Total Transactions</th>

                                <td><?= number_format($totalTransactions); ?></td>

                            </tr>

                            <tr>

                                <th>Today's Transactions</th>

                                <td><?= number_format($todayTransactions); ?></td>

                            </tr>

                            <tr>

                                <th>Low Stock Items</th>

                                <td>

                                    <span class="badge bg-warning">

                                        <?= $lowStock; ?>

                                    </span>

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card shadow-sm h-100">

                    <div class="card-header">

                        <h5>

                            <i class="fa-solid fa-bolt"></i>

                            Quick Actions

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="d-grid gap-2">

                            <a href="../instruments/add.php" class="btn btn-primary">

                                <i class="fa-solid fa-plus"></i>

                                Add Instrument

                            </a>

                            <a href="../stock/stock_in.php" class="btn btn-success">

                                <i class="fa-solid fa-arrow-down"></i>

                                Stock In

                            </a>

                            <a href="../stock/stock_out.php" class="btn btn-warning">

                                <i class="fa-solid fa-arrow-up"></i>

                                Stock Out

                            </a>

                            <a href="../reports/index.php" class="btn btn-dark">

                                <i class="fa-solid fa-chart-column"></i>

                                View Reports

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Recent Activity -->

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">

                    <i class="fa-solid fa-clock-rotate-left"></i>

                    Recent Stock Activity

                </h5>

                <a href="../reports/stock_history_report.php" class="btn btn-sm btn-light">

                    View All

                </a>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle">

                        <thead>

                            <tr>

                                <th>Date</th>

                                <th>Instrument</th>

                                <th>Transaction</th>

                                <th>Quantity</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php if (!empty($activities)): ?>

                            <?php foreach ($activities as $activity): ?>

                                <tr>

                                    <td>

                                        <?= htmlspecialchars($activity['transaction_date']); ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($activity['instrument_name']); ?>

                                    </td>

                                    <td>

                                        <?php if ($activity['transaction_type'] == "Stock In"): ?>

                                            <span class="badge bg-success">

                                                Stock In

                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-danger">

                                                Stock Out

                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <?= number_format($activity['quantity']); ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="4" class="text-center">

                                    No recent stock activity found.

                                </td>

                            </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>