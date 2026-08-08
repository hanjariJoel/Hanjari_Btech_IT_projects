<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

?>

<?php

$stmt = $pdo->query("SELECT * FROM categories ORDER BY category_name");

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php

$stmt = $pdo->query("SELECT * FROM suppliers ORDER BY supplier_name");

$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="wrapper">

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<?php include "../includes/navbar.php"; ?>

<h2 class="mb-4">

<i class="fa-solid fa-plus-circle"></i>

Add Instrument

</h2>

<form action="save.php" method="POST">

<div class="form-container">

<div class="row">

<div class="col-md-6 mb-3">

<label>Instrument Name</label>

<input

type="text"

name="instrument_name"

class="form-control"

required>

</div>

<div class="col-md-6 mb-3">

<label>Brand</label>

<input

type="text"

name="brand"

class="form-control"

required>

</div>

<div class="col-md-6 mb-3">

<label>Category</label>

<select

name="category_id"

class="form-select"

required>

<option value="">Select Category</option>

<?php foreach($categories as $category): ?>

<option

value="<?= $category['id']; ?>">

<?= $category['category_name']; ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Supplier</label>

<select

name="supplier_id"

class="form-select"

required>

<option value="">Select Supplier</option>

<?php foreach($suppliers as $supplier): ?>

<option

value="<?= $supplier['id']; ?>">

<?= $supplier['supplier_name']; ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>SKU</label>

<input

type="text"

name="sku"

class="form-control"

required>

</div>

<div class="col-md-6 mb-3">

<label>Price (KSh)</label>

<input

type="number"

step="0.01"

name="price"

class="form-control"

required>

</div>

<div class="col-md-6 mb-3">

<label>Quantity</label>

<input

type="number"

name="quantity"

class="form-control"

required>

</div>

<div class="col-md-12 mb-3">

<label>Description</label>

<textarea

name="description"

class="form-control"

rows="4"></textarea>

</div>

<div class="mt-3">

<button

type="submit"

class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Save Instrument

</button>

<a

href="index.php"

class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</div>

</form>

</div>

</div>

<?php include "../includes/footer.php"; ?>