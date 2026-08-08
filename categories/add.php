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

<i class="fa-solid fa-folder-plus"></i>

Add Category

</h2>

<form action="save.php" method="POST">

<div class="form-container">

<div class="mb-3">

<label class="form-label">Category Name</label>

<input
type="text"
name="category_name"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Description</label>

<textarea
name="description"
class="form-control"
rows="4"></textarea>

</div>

<button
class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Save Category

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</form>

</div>

</div>

<?php include "../includes/footer.php"; ?>

