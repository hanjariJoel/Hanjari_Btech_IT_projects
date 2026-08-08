<?php

require "../includes/session.php";
require "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $pdo->prepare("
        UPDATE categories
        SET
            category_name = ?,
            description = ?
        WHERE id = ?
    ");

    $stmt->execute([
        trim($_POST['category_name']),
        trim($_POST['description']),
        $_POST['id']
    ]);

    header("Location: index.php?updated=1");
    exit();
}

