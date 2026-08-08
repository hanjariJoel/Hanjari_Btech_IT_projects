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

<i class="fa-solid fa-truck-medical"></i>

Add Supplier

</h2>

<form action="save.php" method="POST">

<div class="form-container">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Supplier Name</label>

<input
type="text"
name="supplier_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Contact Person</label>

<input
type="text"
name="contact_person"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Phone Number</label>

<input
type="text"
name="phone"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Email Address</label>

<input
type="email"
name="email"
class="form-control">

</div>

<div class="col-md-12 mb-3">

<label class="form-label">Physical Address</label>

<textarea
name="address"
rows="3"
class="form-control"></textarea>

</div>

<button class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Save Supplier

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

