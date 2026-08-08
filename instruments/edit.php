<?php

require "../includes/session.php";
require "../config/database.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

/* Fetch Instrument */

$sql = "
SELECT *
FROM instruments
WHERE id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$instrument = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$instrument) {
    header("Location: index.php");
    exit();
}

/* Fetch Categories */

$categories = $pdo->query("
SELECT *
FROM categories
ORDER BY category_name
")->fetchAll(PDO::FETCH_ASSOC);

/* Fetch Suppliers */

$suppliers = $pdo->query("
SELECT *
FROM suppliers
ORDER BY supplier_name
")->fetchAll(PDO::FETCH_ASSOC);

include "../includes/header.php";

?>

<div class="wrapper">

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<?php include "../includes/navbar.php"; ?>

<h2 class="mb-4">
<i class="fa-solid fa-pen"></i>
Edit Instrument
</h2>

<form action="update.php" method="POST">

<input
type="hidden"
name="id"
value="<?= $instrument['id']; ?>">

<div class="form-container">

<div class="row">

<div class="col-md-6 mb-3">

<label>Instrument Name</label>

<input
type="text"
name="instrument_name"
class="form-control"
value="<?= htmlspecialchars($instrument['instrument_name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Brand</label>

<input
type="text"
name="brand"
class="form-control"
value="<?= htmlspecialchars($instrument['brand']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Category</label>

<select
name="category_id"
class="form-select">

<?php foreach($categories as $category): ?>

<option
value="<?= $category['id']; ?>"
<?= ($category['id']==$instrument['category_id']) ? 'selected' : ''; ?>>

<?= htmlspecialchars($category['category_name']); ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Supplier</label>

<select
name="supplier_id"
class="form-select">

<?php foreach($suppliers as $supplier): ?>

<option
value="<?= $supplier['id']; ?>"
<?= ($supplier['id']==$instrument['supplier_id']) ? 'selected' : ''; ?>>

<?= htmlspecialchars($supplier['supplier_name']); ?>

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
value="<?= htmlspecialchars($instrument['sku']); ?>">

</div>

<div class="col-md-6 mb-3">

<label>Price</label>

<input
type="number"
step="0.01"
name="price"
class="form-control"
value="<?= $instrument['price']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Quantity</label>

<input
type="number"
name="quantity"
class="form-control"
value="<?= $instrument['quantity']; ?>">

</div>

<div class="col-md-12 mb-3">

<label>Description</label>

<textarea
name="description"
class="form-control"
rows="4"><?= htmlspecialchars($instrument['description']); ?></textarea>

</div>

<button
class="btn btn-primary">

Update Instrument

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</form>

</div>

</div>

<?php include "../includes/footer.php"; ?>

