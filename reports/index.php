<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

?>

<div class="wrapper">

    <?php include "../includes/sidebar.php"; ?>

    <div class="main-content">

        <?php include "../includes/navbar.php"; ?>

        <!-- Page Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2>
                    <i class="fa-solid fa-chart-column"></i>
                    Reports
                </h2>

                <p class="text-muted mb-0">
                    Generate and print inventory reports for Hanjari's Music House.
                </p>

            </div>

        </div>

        <!-- Business Header -->

        <div class="card shadow-sm mb-4">

            <div class="card-body text-center">

                <h2 class="fw-bold">
                    🎵 Hanjari's Music House
                </h2>

                <h5 class="text-secondary">
                    Stock Maintenance System
                </h5>

                <p class="mb-1">
                    Nairobi, Kenya
                </p>

                <p class="mb-0">
                    📞 +254 712 345 678 |
                    ✉ support@hanjarimusic.co.ke
                </p>

            </div>

        </div>

        <!-- Report Cards -->

        <div class="row g-4">

            <!-- Inventory Report -->

            <div class="col-lg-4 col-md-6">

                <div class="card shadow h-100">

                    <div class="card-body text-center">

                        <i class="fa-solid fa-boxes-stacked fa-4x text-primary mb-3"></i>

                        <h4>Inventory Report</h4>

                        <p class="text-muted">

                            View every instrument currently available in stock together with supplier, category, quantity and price.

                        </p>

                        <a href="inventory_report.php" class="btn btn-primary">

                            <i class="fa-solid fa-eye"></i>

                            View Report

                        </a>

                    </div>

                </div>

            </div>

            <!-- Low Stock -->

            <div class="col-lg-4 col-md-6">

                <div class="card shadow h-100">

                    <div class="card-body text-center">

                        <i class="fa-solid fa-triangle-exclamation fa-4x text-warning mb-3"></i>

                        <h4>Low Stock Report</h4>

                        <p class="text-muted">

                            Displays instruments whose quantities have reached the minimum stock level.

                        </p>

                        <a href="low_stock_report.php" class="btn btn-warning">

                            <i class="fa-solid fa-eye"></i>

                            View Report

                        </a>

                    </div>

                </div>

            </div>

            <!-- Stock History -->

            <div class="col-lg-4 col-md-6">

                <div class="card shadow h-100">

                    <div class="card-body text-center">

                        <i class="fa-solid fa-clock-rotate-left fa-4x text-success mb-3"></i>

                        <h4>Stock History Report</h4>

                        <p class="text-muted">

                            Shows all Stock In and Stock Out transactions carried out in the system.

                        </p>

                        <a href="stock_history_report.php" class="btn btn-success">

                            <i class="fa-solid fa-eye"></i>

                            View Report

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <!-- Footer Information -->

        <div class="card shadow-sm mt-5">

            <div class="card-body">

                <div class="row text-center">

                    <div class="col-md-4">

                        <i class="fa-solid fa-print fa-2x text-dark mb-2"></i>

                        <h6>Printable Reports</h6>

                        <p class="small text-muted">

                            Every report can be printed directly from the browser.

                        </p>

                    </div>

                    <div class="col-md-4">

                        <i class="fa-solid fa-chart-simple fa-2x text-primary mb-2"></i>

                        <h6>Inventory Monitoring</h6>

                        <p class="small text-muted">

                            Keep track of available stock and monitor low-stock items.

                        </p>

                    </div>

                    <div class="col-md-4">

                        <i class="fa-solid fa-clock fa-2x text-success mb-2"></i>

                        <h6>Transaction History</h6>

                        <p class="small text-muted">

                            Review all inventory movements made within the system.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>