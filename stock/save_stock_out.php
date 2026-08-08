<?php

require "../includes/session.php";
require "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $instrument_id = (int) $_POST['instrument_id'];
    $quantity = (int) $_POST['quantity'];
    $transaction_date = $_POST['transaction_date'];
    $notes = trim($_POST['notes']);

    try {

        $pdo->beginTransaction();

        // Check current stock
        $stmt = $pdo->prepare("
            SELECT quantity
            FROM instruments
            WHERE id = ?
            FOR UPDATE
        ");

        $stmt->execute([$instrument_id]);

        $currentQty = (int) $stmt->fetchColumn();

        if ($quantity > $currentQty) {

            $pdo->rollBack();

            header("Location: stock_out.php?error=1");

            exit();

        }

        // Reduce stock
        $stmt = $pdo->prepare("
            UPDATE instruments
            SET quantity = quantity - ?
            WHERE id = ?
        ");

        $stmt->execute([$quantity, $instrument_id]);

        // Get new quantity
        $stmt = $pdo->prepare("
            SELECT quantity
            FROM instruments
            WHERE id = ?
        ");

        $stmt->execute([$instrument_id]);

        $newQty = $stmt->fetchColumn();

        if ($newQty <= 0)
            $status = "Out of Stock";
        elseif ($newQty <= 5)
            $status = "Low Stock";
        else
            $status = "In Stock";

        // Update status
        $stmt = $pdo->prepare("
            UPDATE instruments
            SET status = ?
            WHERE id = ?
        ");

        $stmt->execute([$status, $instrument_id]);

        // Record transaction
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
                ?, 'Stock Out', ?, ?, ?
            )
        ");

        $stmt->execute([
            $instrument_id,
            $quantity,
            $transaction_date,
            $notes
        ]);

        $pdo->commit();

        header("Location: stock_out.php?success=1");
        exit();

    } catch (Exception $e) {

        $pdo->rollBack();

        die($e->getMessage());

    }

}

