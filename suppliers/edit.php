<?php

require "../includes/session.php";
require "../config/database.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM suppliers WHERE id = ?");
$stmt->execute([$id]);

$supplier = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$supplier) {
    header("Location: index.php");
    exit();
}

include "../includes/header.php";

?>

<div class="wrapper">

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<?php include "../includes/navbar.php"; ?>

<h2 class="mb-4">
<i class="fa-solid fa-truck"></i>
Edit Supplier
</h2>

<form action="update.php" method="POST">

<input
type="hidden"
name="id"
value="<?= $supplier['id']; ?>">

<div class="form-container">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Supplier Name</label>

<input
type="text"
name="supplier_name"
class="form-control"
value="<?= htmlspecialchars($supplier['supplier_name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Contact Person</label>

<input
type="text"
name="contact_person"
class="form-control"
value="<?= htmlspecialchars($supplier['contact_person']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Phone Number</label>

<input
type="text"
name="phone"
class="form-control"
value="<?= htmlspecialchars($supplier['phone']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Email Address</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($supplier['email']); ?>">

</div>

<div class="col-md-12 mb-3">

<label class="form-label">Physical Address</label>

<textarea
name="address"
rows="4"
class="form-control"><?= htmlspecialchars($supplier['address']); ?></textarea>

</div>

<button class="btn btn-primary">

<i class="fa-solid fa-floppy-disk"></i>

Update Supplier

</button>

<a href="index.php" class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</form>

</div>

</div>

<?php include "../includes/footer.php"; ?>

