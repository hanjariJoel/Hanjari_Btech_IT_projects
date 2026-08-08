<?php

require "../includes/session.php";
require "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $instrument_id = (int)$_POST['instrument_id'];
    $quantity = (int)$_POST['quantity'];
    $transaction_date = $_POST['transaction_date'];
    $notes = trim($_POST['notes']);

    try {

        $pdo->beginTransaction();

        /* Update Quantity */

        $stmt = $pdo->prepare("
            UPDATE instruments
            SET quantity = quantity + ?
            WHERE id = ?
        ");

        $stmt->execute([$quantity, $instrument_id]);

        /* Update Status */

        $stmt = $pdo->prepare("
            SELECT quantity
            FROM instruments
            WHERE id = ?
        ");

        $stmt->execute([$instrument_id]);

        $currentQty = $stmt->fetchColumn();

        if ($currentQty <= 0) {
            $status = "Out of Stock";
        } elseif ($currentQty <= 5) {
            $status = "Low Stock";
        } else {
            $status = "In Stock";
        }

        $stmt = $pdo->prepare("
            UPDATE instruments
            SET status = ?
            WHERE id = ?
        ");

        $stmt->execute([$status, $instrument_id]);

        /* Record Transaction */

        $stmt = $pdo->prepare("
            INSERT INTO stock_transactions
            (
                instrument_id,
                transaction_type,
                quantity,
                transaction_date,
                notes
            )
            VALUES
            (
                ?, 'Stock In', ?, ?, ?
            )
        ");

        $stmt->execute([
            $instrument_id,
            $quantity,
            $transaction_date,
            $notes
        ]);

        $pdo->commit();

        header("Location: stock_in.php?success=1");
        exit();

    } catch (Exception $e) {

        $pdo->rollBack();

        die("Transaction failed: " . $e->getMessage());
    }

}

