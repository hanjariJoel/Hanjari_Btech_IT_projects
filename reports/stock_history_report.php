<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

/*
|--------------------------------------------------------------------------
| Retrieve Stock History
|--------------------------------------------------------------------------
*/

$sql = "
SELECT
    st.transaction_date,
    i.instrument_name,
    st.transaction_type,
    st.quantity,
    st.notes
FROM stock_transactions st
INNER JOIN instruments i
    ON st.instrument_id = i.id
ORDER BY st.transaction_date DESC, st.id DESC
";

$stmt = $pdo->query($sql);
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="wrapper">

    <?php include "../includes/sidebar.php"; ?>

    <div class="main-content">

        <?php include "../includes/navbar.php"; ?>

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

                <p class="mb-1">
                    📞 +254 712 345 678 |
                    ✉ support@hanjarimusic.co.ke
                </p>

                <hr>

                <h4 class="fw-bold">
                    Stock History Report
                </h4>

                <small class="text-muted">
                    Generated on:
                    <?= date("d M Y, h:i A"); ?>
                </small>

            </div>

        </div>

        <!-- Buttons -->

        <div class="d-flex justify-content-between mb-4">

            <a href="index.php" class="btn btn-secondary">

                <i class="fa-solid fa-arrow-left"></i>

                Back

            </a>

            <a href="print_report.php?type=history"
class="btn btn-dark">

<i class="fa-solid fa-print"></i>

Print Report

</a>

        </div>

        <!-- Report Table -->

        <div class="card shadow">

            <div class="card-header bg-success text-white">

                <h5 class="mb-0">

                    Stock Movement History

                </h5>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>#</th>
                                <th>Date</th>
                                <th>Instrument</th>
                                <th>Transaction</th>
                                <th>Quantity</th>
                                <th>Notes</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php if(count($history) > 0): ?>

                            <?php $count = 1; ?>

                            <?php foreach($history as $row): ?>

                            <tr>

                                <td><?= $count++; ?></td>

                                <td><?= htmlspecialchars($row['transaction_date']); ?></td>

                                <td><?= htmlspecialchars($row['instrument_name']); ?></td>

                                <td>

                                    <?php if($row['transaction_type'] == "Stock In"): ?>

                                        <span class="badge bg-success">

                                            Stock In

                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-danger">

                                            Stock Out

                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td><?= $row['quantity']; ?></td>

                                <td>

                                    <?= htmlspecialchars($row['notes']); ?>

                                </td>

                            </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="6" class="text-center">

                                    No stock transactions found.

                                </td>

                            </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- Summary -->

        <div class="row mt-4">

            <div class="col-md-4">

                <div class="card shadow-sm text-center">

                    <div class="card-body">

                        <h6>Total Transactions</h6>

                        <h2>

                            <?= count($history); ?>

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-8">

                <div class="alert alert-success">

                    <strong>Report Information</strong>

                    <hr>

                    This report provides a complete history of all inventory
                    movements performed in the system, including Stock In and
                    Stock Out transactions. It helps monitor inventory flow
                    and supports auditing of stock activities.

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>