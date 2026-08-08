<?php

require "../../includes/session.php";
require "../../config/database.php";

if ($_SESSION['role'] !== 'Administrator') {
    header("Location: ../../dashboard/dashboard.php");
    exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php?error=" . urlencode("Invalid user."));
    exit();
}

/* Never allow administrator account deletion */
$stmt = $pdo->prepare("
    SELECT id, role
    FROM users
    WHERE id = ?
");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: index.php?error=" . urlencode("User not found."));
    exit();
}

if ($user['role'] === 'Administrator') {
    header("Location: index.php?error=" . urlencode("The administrator account cannot be deleted."));
    exit();
}

/* Prevent deleting the currently logged-in account */
if ((int)$id === (int)$_SESSION['user_id']) {
    header("Location: index.php?error=" . urlencode("You cannot delete your own account."));
    exit();
}

$delete = $pdo->prepare("
    DELETE FROM users
    WHERE id = ?
    AND role = 'Storekeeper'
");

$delete->execute([$id]);

if ($delete->rowCount() > 0) {

    header("Location: index.php?success=" . urlencode("Storekeeper account deleted successfully."));
    exit();
}

header("Location: index.php?error=" . urlencode("Unable to delete the user."));
exit();