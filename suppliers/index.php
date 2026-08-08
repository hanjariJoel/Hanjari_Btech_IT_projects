<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

$stmt = $pdo->query("
SELECT *
FROM suppliers
ORDER BY supplier_name
");

$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="wrapper">

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<?php include "../includes/navbar.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>

<i class="fa-solid fa-truck"></i>

Suppliers

</h2>

<a href="add.php" class="btn btn-primary">

<i class="fa-solid fa-plus"></i>

Add Supplier

</a>

</div>

<?php if(isset($_GET['success'])): ?>

<div class="alert alert-success">

Supplier added successfully.

</div>

<?php endif; ?>

<?php if(isset($_GET['updated'])): ?>

<div class="alert alert-info">

Supplier updated successfully.

</div>

<?php endif; ?>

<?php if(isset($_GET['deleted'])): ?>

<div class="alert alert-danger">

Supplier deleted successfully.

</div>

<?php endif; ?>

<table class="table table-hover">

<thead>

<tr>

<th>ID</th>
<th>Supplier</th>
<th>Contact Person</th>
<th>Phone</th>
<th>Email</th>
<th>Address</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php foreach($suppliers as $supplier): ?>

<tr>

<td><?= $supplier['id']; ?></td>

<td><?= htmlspecialchars($supplier['supplier_name']); ?></td>

<td><?= htmlspecialchars($supplier['contact_person']); ?></td>

<td><?= htmlspecialchars($supplier['phone']); ?></td>

<td><?= htmlspecialchars($supplier['email']); ?></td>

<td><?= htmlspecialchars($supplier['address']); ?></td>

<td>

<a href="edit.php?id=<?= $supplier['id']; ?>" class="btn btn-warning btn-sm">

<i class="fa-solid fa-pen"></i>

</a>

<a href="delete.php?id=<?= $supplier['id']; ?>" class="btn btn-danger btn-sm"
onclick="return confirm('Delete this supplier?');">

<i class="fa-solid fa-trash"></i>

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

<?php include "../includes/footer.php"; ?>

