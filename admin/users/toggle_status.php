<?php

require_once "../../config/auth.php";
requireRole("Administrator");

require_once "../../config/database.php";


/*
|--------------------------------------------------------------------------
| ALLOW POST REQUESTS ONLY
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| GET USER ID
|--------------------------------------------------------------------------
*/

$userId = filter_input(
    INPUT_POST,
    'id',
    FILTER_VALIDATE_INT
);

if (!$userId || $userId <= 0) {

    header(
        "Location: index.php?error=" .
        urlencode("Invalid user selected.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| PREVENT ADMIN FROM DEACTIVATING THEMSELVES
|--------------------------------------------------------------------------
*/

if ($userId === (int)$_SESSION['user_id']) {

    header(
        "Location: index.php?error=" .
        urlencode(
            "You cannot deactivate your own account."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| FIND USER
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        id,
        full_name,
        role,
        status
    FROM users
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$userId]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| USER NOT FOUND
|--------------------------------------------------------------------------
*/

if (!$user) {

    header(
        "Location: index.php?error=" .
        urlencode("User not found.")
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| ONLY APPROVED / INACTIVE USERS
|--------------------------------------------------------------------------
*/

if (
    $user['status'] !== 'Approved' &&
    $user['status'] !== 'Inactive'
) {

    header(
        "Location: index.php?error=" .
        urlencode(
            "Only approved or inactive accounts can have their status changed."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| DETERMINE NEW STATUS
|--------------------------------------------------------------------------
*/

if ($user['status'] === 'Approved') {

    $newStatus = 'Inactive';
    $action = 'deactivated';

} else {

    $newStatus = 'Approved';
    $action = 'activated';
}


/*
|--------------------------------------------------------------------------
| UPDATE STATUS
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    UPDATE users
    SET status = ?
    WHERE id = ?
");

$stmt->execute([
    $newStatus,
    $userId
]);


/*
|--------------------------------------------------------------------------
| CONFIRM UPDATE
|--------------------------------------------------------------------------
*/

if ($stmt->rowCount() !== 1) {

    header(
        "Location: index.php?error=" .
        urlencode(
            "The user's status could not be updated."
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
        "User " . $action . " successfully."
    )
);

exit;