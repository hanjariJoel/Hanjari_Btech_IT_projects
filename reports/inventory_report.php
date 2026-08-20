<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

/*
|--------------------------------------------------------------------------
| Retrieve Inventory Data
|--------------------------------------------------------------------------
*/

$sql = "
SELECT
    i.instrument_name,
    i.brand,
    c.category_name,
    s.supplier_name,
    i.quantity,
    i.price,
    i.status
FROM instruments i
INNER JOIN categories c
    ON i.category_id = c.id
INNER JOIN suppliers s
    ON i.supplier_id = s.id
ORDER BY i.instrument_name ASC
";

$stmt = $pdo->query($sql);
$inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="wrapper">

    <?php include "../includes/sidebar.php"; ?>

    <div class="main-content">

        <?php include "../includes/navbar.php"; ?>

        <!-- ========================= -->
        <!-- Business Header -->
        <!-- ========================= -->

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
                    📞 +254 740 704619
                    |
                    ✉ support@hanjarimusic.co.ke
                </p>

                <hr>

                <h4 class="fw-bold">

                    Inventory Report

                </h4>

                <small class="text-muted">

                    Generated on:

                    <?= date("d M Y, h:i A"); ?>

                </small>

            </div>

        </div>

        <!-- ========================= -->
        <!-- Buttons -->
        <!-- ========================= -->

        <div class="d-flex justify-content-between mb-4">

            <a href="index.php" class="btn btn-secondary">

                <i class="fa-solid fa-arrow-left"></i>

                Back

            </a>

            <a href="print_report.php?type=inventory"
class="btn btn-dark">

<i class="fa-solid fa-print"></i>

Print Report

</a>

        </div>

        <!-- ========================= -->
        <!-- Inventory Table -->
        <!-- ========================= -->

        <div class="card shadow">

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">

                    Complete Inventory List

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

                                <th>Category</th>

                                <th>Supplier</th>

                                <th>Quantity</th>

                                <th>Price (KSh)</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php if(count($inventory) > 0): ?>

                            <?php $count = 1; ?>

                            <?php foreach($inventory as $item): ?>

                            <tr>

                                <td><?= $count++; ?></td>

                                <td><?= htmlspecialchars($item['instrument_name']); ?></td>

                                <td><?= htmlspecialchars($item['brand']); ?></td>

                                <td><?= htmlspecialchars($item['category_name']); ?></td>

                                <td><?= htmlspecialchars($item['supplier_name']); ?></td>

                                <td><?= $item['quantity']; ?></td>

                                <td>

                                    KSh

                                    <?= number_format($item['price'],2); ?>

                                </td>

                                <td>

                                    <?php

                                    if($item['status']=="In Stock"){

                                        echo '<span class="badge bg-success">In Stock</span>';

                                    }

                                    elseif($item['status']=="Low Stock"){

                                        echo '<span class="badge bg-warning text-dark">Low Stock</span>';

                                    }

                                    else{

                                        echo '<span class="badge bg-danger">Out of Stock</span>';

                                    }

                                    ?>

                                </td>

                            </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="8" class="text-center">

                                    No inventory records found.

                                </td>

                            </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- ========================= -->
        <!-- Summary -->
        <!-- ========================= -->

        <div class="row mt-4">

            <div class="col-md-4">

                <div class="card text-center shadow-sm">

                    <div class="card-body">

                        <h6>Total Instruments</h6>

                        <h3>

                            <?= count($inventory); ?>

                        </h3>

                    </div>

                </div>

            </div>

            <div class="col-md-8">

                <div class="alert alert-info">

                    <strong>Report Information</strong>

                    <hr>

                    This report contains every instrument currently registered
                    in the Hanjari's Music House Stock Maintenance System,
                    together with its category, supplier, quantity available,
                    selling price and stock status.

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>