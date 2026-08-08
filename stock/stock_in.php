<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

$instruments = $pdo->query("
SELECT id, instrument_name
FROM instruments
ORDER BY instrument_name
")->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="wrapper">

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<?php include "../includes/navbar.php"; ?>

<h2 class="mb-4">
<i class="fa-solid fa-arrow-down"></i>
Stock In
</h2>

<form action="save_stock_in.php" method="POST">

<div class="form-container">

<div class="row">

<div class="col-md-6 mb-3">

<label>Instrument</label>

<select
name="instrument_id"
class="form-select"
required>

<option value="">Select Instrument</option>

<?php foreach($instruments as $instrument): ?>

<option value="<?= $instrument['id']; ?>">

<?= htmlspecialchars($instrument['instrument_name']); ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Quantity Received</label>

<input
type="number"
name="quantity"
class="form-control"
min="1"
required>

</div>

<div class="col-md-6 mb-3">

<label>Date Received</label>

<input
type="date"
name="transaction_date"
class="form-control"
value="<?= date('Y-m-d'); ?>"
required>

</div>

<div class="col-md-12 mb-3">

<label>Notes</label>

<textarea
name="notes"
rows="4"
class="form-control"></textarea>

</div>

<button
class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Save Stock In

</button>

<a
href="../dashboard/dashboard.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</form>

</div>

</div>

<?php include "../includes/footer.php"; ?>

