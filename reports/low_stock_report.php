<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

/*
|--------------------------------------------------------------------------
| Retrieve Low Stock Items
|--------------------------------------------------------------------------
*/

$sql = "
SELECT
    instrument_name,
    brand,
    quantity,
    price,
    status
FROM instruments
WHERE quantity <= 5
ORDER BY quantity ASC
";

$stmt = $pdo->query($sql);
$lowStock = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

                    Low Stock Report

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

            <a href="print_report.php?type=lowstock"
class="btn btn-dark">

<i class="fa-solid fa-print"></i>

Print Report

</a>

        </div>

        <!-- Report Table -->

        <div class="card shadow">

            <div class="card-header bg-warning">

                <h5 class="mb-0">

                    Instruments Running Low

                </h5>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>#</th>

                                <th>Instrument</th>

                                <th>Brand</th>

                                <th>Quantity</th>

                                <th>Price (KSh)</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php if(count($lowStock) > 0): ?>

                            <?php $count = 1; ?>

                            <?php foreach($lowStock as $item): ?>

                            <tr>

                                <td><?= $count++; ?></td>

                                <td><?= htmlspecialchars($item['instrument_name']); ?></td>

                                <td><?= htmlspecialchars($item['brand']); ?></td>

                                <td><?= $item['quantity']; ?></td>

                                <td>

                                    KSh <?= number_format($item['price'],2); ?>

                                </td>

                                <td>

                                    <?php

                                    if($item['status']=="Low Stock"){

                                        echo '<span class="badge bg-warning text-dark">Low Stock</span>';

                                    }

                                    elseif($item['status']=="Out of Stock"){

                                        echo '<span class="badge bg-danger">Out of Stock</span>';

                                    }

                                    else{

                                        echo '<span class="badge bg-success">In Stock</span>';

                                    }

                                    ?>

                                </td>

                            </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="6" class="text-center">

                                    No low stock items found.

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

                        <h6>Low Stock Items</h6>

                        <h2>

                            <?= count($lowStock); ?>

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-8">

                <div class="alert alert-warning">

                    <strong>Report Information</strong>

                    <hr>

                    This report lists all instruments whose available quantity
                    is five (5) units or fewer. These items should be
                    restocked soon to avoid stock shortages.

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>