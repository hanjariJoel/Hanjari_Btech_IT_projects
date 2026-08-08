<?php

require "../includes/session.php";
require "../config/database.php";

$type = $_GET['type'] ?? 'inventory';

$title = "Inventory Report";

switch($type){

    case "lowstock":

        $title = "Low Stock Report";

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

        break;

    case "history":

        $title = "Stock History Report";

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
        ORDER BY st.transaction_date DESC,
                 st.id DESC
        ";

        break;

    default:

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
        ORDER BY i.instrument_name
        ";

}

$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title><?= $title; ?></title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{

    padding:40px;

    font-family:Arial, Helvetica, sans-serif;

}

table{

    width:100%;

}

@media print{

    .no-print{

        display:none;

    }

}

</style>

</head>

<body>

<div class="text-center mb-4">

<h2>

🎵 Hanjari's Music House

</h2>

<h5>

Stock Maintenance System

</h5>

<p>

Nairobi, Kenya

<br>

📞 +254 712 345 678

|

✉ support@hanjarimusic.co.ke

</p>

<h4>

<?= $title; ?>

</h4>

<small>

Generated on

<?= date("d M Y, h:i A"); ?>

</small>

</div>

<div class="mb-4 no-print">

<button

onclick="window.print();"
class="btn btn-dark">

<i class="fa-solid fa-print"></i>

Print

</button>

<a
href="index.php"
class="btn btn-secondary">

Back

</a>

</div>

<?php if($type=="inventory"): ?>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>#</th>

<th>Instrument</th>

<th>Brand</th>

<th>Category</th>

<th>Supplier</th>

<th>Qty</th>

<th>Price</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php $count=1; ?>

<?php foreach($data as $row): ?>

<tr>

<td><?= $count++; ?></td>

<td><?= htmlspecialchars($row['instrument_name']); ?></td>

<td><?= htmlspecialchars($row['brand']); ?></td>

<td><?= htmlspecialchars($row['category_name']); ?></td>

<td><?= htmlspecialchars($row['supplier_name']); ?></td>

<td><?= $row['quantity']; ?></td>

<td>KSh <?= number_format($row['price'],2); ?></td>

<td><?= htmlspecialchars($row['status']); ?></td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

<?php endif; ?>

<?php if($type=="lowstock"): ?>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>#</th>

<th>Instrument</th>

<th>Brand</th>

<th>Qty</th>

<th>Price</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php $count=1; ?>

<?php foreach($data as $row): ?>

<tr>

<td><?= $count++; ?></td>

<td><?= htmlspecialchars($row['instrument_name']); ?></td>

<td><?= htmlspecialchars($row['brand']); ?></td>

<td><?= $row['quantity']; ?></td>

<td>KSh <?= number_format($row['price'],2); ?></td>

<td><?= htmlspecialchars($row['status']); ?></td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

<?php endif; ?>

<?php if($type=="history"): ?>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>#</th>

<th>Date</th>

<th>Instrument</th>

<th>Type</th>

<th>Quantity</th>

<th>Notes</th>

</tr>

</thead>

<tbody>

<?php $count=1; ?>

<?php foreach($data as $row): ?>

<tr>

<td><?= $count++; ?></td>

<td><?= htmlspecialchars($row['transaction_date']); ?></td>

<td><?= htmlspecialchars($row['instrument_name']); ?></td>

<td><?= htmlspecialchars($row['transaction_type']); ?></td>

<td><?= $row['quantity']; ?></td>

<td><?= htmlspecialchars($row['notes']); ?></td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

<?php endif; ?>

</body>

</html>

