<?php

session_start();

require "../config/database.php";


/*
|--------------------------------------------------------------------------
| ALLOW POST REQUESTS ONLY
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: login.php");

    exit;
}


/*
|--------------------------------------------------------------------------
| GET LOGIN DATA
|--------------------------------------------------------------------------
*/

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';


/*
|--------------------------------------------------------------------------
| VALIDATE INPUT
|--------------------------------------------------------------------------
*/

if ($username === '' || $password === '') {

    header(
        "Location: login.php?error=" .
        urlencode(
            "Please enter your username and password."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| FIND USER
|--------------------------------------------------------------------------
|
| We now retrieve STATUS as well because the system needs to know
| whether the Administrator has approved the account.
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        id,
        full_name,
        username,
        password,
        role,
        status
    FROM users
    WHERE username = ?
    LIMIT 1
");

$stmt->execute([$username]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| CHECK USERNAME AND PASSWORD
|--------------------------------------------------------------------------
*/

if (
    !$user ||
    !password_verify($password, $user['password'])
) {

    header(
        "Location: login.php?error=" .
        urlencode(
            "Invalid username or password."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| CHECK ACCOUNT STATUS
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| PENDING
|--------------------------------------------------------------------------
*/

if ($user['status'] === 'Pending') {

    header(
        "Location: login.php?error=" .
        urlencode(
            "Your account is awaiting Administrator approval."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| REJECTED
|--------------------------------------------------------------------------
*/

if ($user['status'] === 'Rejected') {

    header(
        "Location: login.php?error=" .
        urlencode(
            "Your registration request was rejected."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| INACTIVE
|--------------------------------------------------------------------------
*/

if ($user['status'] === 'Inactive') {

    header(
        "Location: login.php?error=" .
        urlencode(
            "Your account has been deactivated. Contact the Administrator."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| ONLY APPROVED USERS CONTINUE
|--------------------------------------------------------------------------
*/

if ($user['status'] !== 'Approved') {

    header(
        "Location: login.php?error=" .
        urlencode(
            "Your account cannot access the system."
        )
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| REGENERATE SESSION ID
|--------------------------------------------------------------------------
*/

session_regenerate_id(true);


/*
|--------------------------------------------------------------------------
| CREATE SESSION
|--------------------------------------------------------------------------
*/

$_SESSION['user_id'] = (int)$user['id'];

$_SESSION['full_name'] = $user['full_name'];

$_SESSION['username'] = $user['username'];

$_SESSION['role'] = $user['role'];


/*
|--------------------------------------------------------------------------
| LOGIN SUCCESS
|--------------------------------------------------------------------------
*/

header("Location: ../dashboard/dashboard.php");

exit;