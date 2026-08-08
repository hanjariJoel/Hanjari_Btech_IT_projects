<?php

require "../includes/session.php";
require "../config/database.php";

include "../includes/header.php";

$id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
SELECT *
FROM users
WHERE id=?
");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<div class="wrapper">

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<?php include "../includes/navbar.php"; ?>

<h2>Edit Profile</h2>

<form
action="update.php"
method="POST">

<input
type="hidden"
name="id"
value="<?= $user['id']; ?>">

<div class="mb-3">

<label>Full Name</label>

<input
type="text"
name="full_name"
class="form-control"
value="<?= htmlspecialchars($user['full_name']); ?>"
required>

</div>

<div class="mb-3">

<label>Username</label>

<input
type="text"
name="username"
class="form-control"
value="<?= htmlspecialchars($user['username']); ?>"
required>

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($user['email']); ?>"
required>

</div>


<div class="mb-3">

<label>

Phone Number

</label>

<input
type="text"
name="phone"
class="form-control"
value="<?= htmlspecialchars($user['phone']); ?>">

</div>


<button
class="btn btn-success">

Update Profile

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

<?php include "../includes/footer.php"; ?>

