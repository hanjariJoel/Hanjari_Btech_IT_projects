<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

$stmt = $pdo->query("
    SELECT *
    FROM categories
    ORDER BY category_name
");

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="wrapper">

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<?php include "../includes/navbar.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>
<i class="fa-solid fa-folder"></i>
Categories
</h2>

<a href="add.php" class="btn btn-primary">
<i class="fa-solid fa-plus"></i>
Add Category
</a>

</div>

<?php if(isset($_GET['success'])): ?>

<div class="alert alert-success">
Category added successfully.
</div>

<?php endif; ?>

<?php if(isset($_GET['updated'])): ?>

<div class="alert alert-info">
Category updated successfully.
</div>

<?php endif; ?>

<?php if(isset($_GET['deleted'])): ?>

<div class="alert alert-danger">
Category deleted successfully.
</div>

<?php endif; ?>

<table class="table table-hover">

<thead>

<tr>

<th>ID</th>

<th>Category Name</th>

<th>Description</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php foreach($categories as $category): ?>

<tr>

<td><?= $category['id']; ?></td>

<td><?= htmlspecialchars($category['category_name']); ?></td>

<td><?= htmlspecialchars($category['description']); ?></td>

<td>

<a
href="edit.php?id=<?= $category['id']; ?>"
class="btn btn-warning btn-sm">

<i class="fa-solid fa-pen"></i>

</a>

<a
href="delete.php?id=<?= $category['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this category?');">

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

