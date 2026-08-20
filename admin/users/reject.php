<?php

require "../../config/auth.php";
requireRole("Administrator");

require_once "../../config/database.php";


/*
|--------------------------------------------------------------------------
| GET USER ID
|--------------------------------------------------------------------------
*/

$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);

if (!$id) {

    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| FIND PENDING STOREKEEPER
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM users
    WHERE id = ?
      AND role = 'Storekeeper'
      AND status = 'Pending'
    LIMIT 1
");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {

    header(
        "Location: index.php?error=" .
        urlencode(
            "The storekeeper request could not be found or has already been processed."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| REJECT ACCOUNT
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    UPDATE users
    SET status = 'Rejected'
    WHERE id = ?
      AND role = 'Storekeeper'
      AND status = 'Pending'
");

$stmt->execute([$id]);


/*
|--------------------------------------------------------------------------
| CONFIRM UPDATE
|--------------------------------------------------------------------------
*/

if ($stmt->rowCount() !== 1) {

    header(
        "Location: index.php?error=" .
        urlencode(
            "The storekeeper registration could not be rejected."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| SUCCESS
|--------------------------------------------------------------------------
*/

header(
    "Location: index.php?success=" .
    urlencode(
        "Storekeeper registration has been rejected."
    )
);

exit;