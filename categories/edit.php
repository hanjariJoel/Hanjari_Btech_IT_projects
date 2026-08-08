<?php

require "../includes/session.php";
require "../config/database.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);

$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
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
    <i class="fa-solid fa-folder-open"></i>
    Edit Category
</h2>

<form action="update.php" method="POST">

<input type="hidden" name="id" value="<?= $category['id']; ?>">

<div class="form-container">

<div class="mb-3">

<label class="form-label">Category Name</label>

<input
type="text"
name="category_name"
class="form-control"
value="<?= htmlspecialchars($category['category_name']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Description</label>

<textarea
name="description"
rows="4"
class="form-control"><?= htmlspecialchars($category['description']); ?></textarea>

</div>

<button class="btn btn-primary">
<i class="fa-solid fa-floppy-disk"></i>
Update Category
</button>

<a href="index.php" class="btn btn-secondary">
Cancel
</a>

</div>

</form>

</div>

</div>

<?php include "../includes/footer.php"; ?>

