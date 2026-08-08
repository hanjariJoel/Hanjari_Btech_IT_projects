<?php

require "../includes/session.php";
require "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $instrument_name = trim($_POST['instrument_name']);
    $brand = trim($_POST['brand']);
    $category_id = $_POST['category_id'];
    $supplier_id = $_POST['supplier_id'];
    $sku = trim($_POST['sku']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = trim($_POST['description']);

    // Determine status automatically
    if ($quantity <= 0) {
        $status = "Out of Stock";
    } elseif ($quantity <= 5) {
        $status = "Low Stock";
    } else {
        $status = "In Stock";
    }

    $sql = "INSERT INTO instruments
    (
        instrument_name,
        category_id,
        supplier_id,
        brand,
        sku,
        price,
        quantity,
        description,
        status
    )
    VALUES
    (
        :instrument_name,
        :category_id,
        :supplier_id,
        :brand,
        :sku,
        :price,
        :quantity,
        :description,
        :status
    )";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':instrument_name' => $instrument_name,
        ':category_id' => $category_id,
        ':supplier_id' => $supplier_id,
        ':brand' => $brand,
        ':sku' => $sku,
        ':price' => $price,
        ':quantity' => $quantity,
        ':description' => $description,
        ':status' => $status
    ]);

    header("Location: index.php?success=1");
    exit();
}

