<?php

require "../includes/session.php";
require "../config/database.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$stmt=$pdo->prepare("
INSERT INTO suppliers
(
supplier_name,
contact_person,
phone,
email,
address
)

VALUES
(?,?,?,?,?)
");

$stmt->execute([

trim($_POST['supplier_name']),
trim($_POST['contact_person']),
trim($_POST['phone']),
trim($_POST['email']),
trim($_POST['address'])

]);

header("Location:index.php?success=1");
exit();

}

