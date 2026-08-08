<?php

require "../includes/session.php";
require "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $category_name = trim($_POST['category_name']);
    $description = trim($_POST['description']);

    $stmt = $pdo->prepare("
        INSERT INTO categories
        (category_name, description)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $category_name,
        $description
    ]);

    header("Location: index.php?success=1");
    exit();
}

