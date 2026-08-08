<?php

require "../includes/session.php";
require "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $pdo->prepare("
        UPDATE suppliers
        SET
            supplier_name = ?,
            contact_person = ?,
            phone = ?,
            email = ?,
            address = ?
        WHERE id = ?
    ");

    $stmt->execute([
        trim($_POST['supplier_name']),
        trim($_POST['contact_person']),
        trim($_POST['phone']),
        trim($_POST['email']),
        trim($_POST['address']),
        $_POST['id']
    ]);

    header("Location: index.php?updated=1");
    exit();
}

