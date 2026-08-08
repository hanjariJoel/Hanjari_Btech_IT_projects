<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

?>

<div class="wrapper">

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<?php include "../includes/navbar.php"; ?>

<h2 class="mb-4">

🎵 Instruments

</h2>


<?php if(isset($_GET['success'])): ?>

<div class="alert alert-success">
    Instrument added successfully.
</div>

<?php endif; ?>

<?php if(isset($_GET['updated'])): ?>

<div class="alert alert-info">
    Instrument updated successfully.
</div>

<?php endif; ?>

<?php if(isset($_GET['deleted'])): ?>

<div class="alert alert-danger">
    Instrument deleted successfully.
</div>

<?php endif; ?>


<?php

$sql = "

SELECT

instruments.*,

categories.category_name,

suppliers.supplier_name

FROM instruments

JOIN categories

ON instruments.category_id=categories.id

JOIN suppliers

ON instruments.supplier_id=suppliers.id

ORDER BY instrument_name

";

$stmt = $pdo->query($sql);

$instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="d-flex justify-content-between mb-3">

<a
href="add.php"
class="btn btn-primary">

<i class="fa fa-plus"></i>

Add Instrument

</a>

<form class="d-flex">

<input
class="form-control"

placeholder="Search">

<button
class="btn btn-dark">

Search

</button>

</form>

</div>

<table class="table table-hover">

<thead>

<tr>

<th>ID</th>

<th>Instrument</th>

<th>Brand</th>

<th>Category</th>

<th>Supplier</th>

<th>Quantity</th>

<th>Price</th>

<th>Status</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php foreach($instruments as $instrument): ?>

<tr>

<td><?= $instrument['id'] ?></td>

<td><?= $instrument['instrument_name'] ?></td>

<td><?= $instrument['brand'] ?></td>

<td><?= $instrument['category_name'] ?></td>

<td><?= $instrument['supplier_name'] ?></td>

<td><?= $instrument['quantity'] ?></td>

<td>KSh <?= number_format($instrument['price'],2) ?></td>

<td>

<?php

if($instrument['quantity']>5){

echo "<span class='badge-success'>In Stock</span>";

}

elseif($instrument['quantity']>0){

echo "<span class='badge-warning'>Low Stock</span>";

}

else{

echo "<span class='badge-danger'>Out of Stock</span>";

}

?>

</td>

<td>

<a
href="edit.php?id=<?= $instrument['id'] ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="delete.php?id=<?= $instrument['id'] ?>"
class="btn btn-danger btn-sm">

Delete

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

<?php

include "../includes/footer.php";

?>

