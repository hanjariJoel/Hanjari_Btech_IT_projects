<?php

require "../includes/session.php";
require "../config/database.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$id=$_POST['id'];

$instrument_name=trim($_POST['instrument_name']);
$brand=trim($_POST['brand']);
$category_id=$_POST['category_id'];
$supplier_id=$_POST['supplier_id'];
$sku=trim($_POST['sku']);
$price=$_POST['price'];
$quantity=$_POST['quantity'];
$description=trim($_POST['description']);

if($quantity<=0)
    $status="Out of Stock";
elseif($quantity<=5)
    $status="Low Stock";
else
    $status="In Stock";

$sql="UPDATE instruments SET

instrument_name=?,
category_id=?,
supplier_id=?,
brand=?,
sku=?,
price=?,
quantity=?,
description=?,
status=?

WHERE id=?";

$stmt=$pdo->prepare($sql);

$stmt->execute([
$instrument_name,
$category_id,
$supplier_id,
$brand,
$sku,
$price,
$quantity,
$description,
$status,
$id
]);

header("Location:index.php?updated=1");
exit();

}