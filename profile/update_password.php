<?php

declare(strict_types=1);

session_start();

require "../config/database.php";

/*
|--------------------------------------------------------------------------
| Request Validation
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: change_password.php");
    exit();

}

if (!isset($_SESSION['user_id'])) {

    header("Location: ../auth/login.php?error=Please+login+first");
    exit();

}

$userId = (int) $_SESSION['user_id'];

$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

/*
|--------------------------------------------------------------------------
| Basic Validation
|--------------------------------------------------------------------------
*/

if (
    empty($currentPassword) ||
    empty($newPassword) ||
    empty($confirmPassword)
) {

    header(
        "Location: change_password.php?error=Please+fill+in+all+password+fields"
    );

    exit();

}

if (strlen($newPassword) < 8) {

    header(
        "Location: change_password.php?error=New+password+must+be+at+least+8+characters"
    );

    exit();

}

if ($newPassword !== $confirmPassword) {

    header(
        "Location: change_password.php?error=New+passwords+do+not+match"
    );

    exit();

}

if ($currentPassword === $newPassword) {

    header(
        "Location: change_password.php?error=New+password+must+be+different+from+your+current+password"
    );

    exit();

}

/*
|--------------------------------------------------------------------------
| Password Strength
|--------------------------------------------------------------------------
*/

if (
    !preg_match('/[A-Z]/', $newPassword) ||
    !preg_match('/[a-z]/', $newPassword) ||
    !preg_match('/[0-9]/', $newPassword) ||
    !preg_match('/[^A-Za-z0-9]/', $newPassword)
) {

    header(
        "Location: change_password.php?error=Password+must+contain+uppercase,+lowercase,+number+and+special+character"
    );

    exit();

}

/*
|--------------------------------------------------------------------------
| Retrieve Current User
|--------------------------------------------------------------------------
*/

try {

    $stmt = $pdo->prepare("
        SELECT password
        FROM users
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([$userId]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {

        header(
            "Location: ../auth/login.php?error=User+account+not+found"
        );

        exit();

    }

    /*
    |--------------------------------------------------------------------------
    | Verify Existing Password
    |--------------------------------------------------------------------------
    */

    $passwordValid = false;

    if (
        password_verify(
            $currentPassword,
            $user['password']
        )
    ) {

        $passwordValid = true;

    } elseif (
        hash_equals(
            (string) $user['password'],
            $currentPassword
        )
    ) {

        /*
        | Supports existing plain-text passwords so the
        | system can transition them to secure hashes.
        */

        $passwordValid = true;

    }

    if (!$passwordValid) {

        header(
            "Location: change_password.php?error=Current+password+is+incorrect"
        );

        exit();

    }

    /*
    |--------------------------------------------------------------------------
    | Hash New Password
    |--------------------------------------------------------------------------
    */

    $hashedPassword = password_hash(
        $newPassword,
        PASSWORD_DEFAULT
    );

    if ($hashedPassword === false) {

        header(
            "Location: change_password.php?error=Unable+to+secure+the+new+password"
        );

        exit();

    }

    /*
    |--------------------------------------------------------------------------
    | Update Password
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE users
        SET password = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $hashedPassword,
        $userId
    ]);

    /*
    |--------------------------------------------------------------------------
    | Log Out After Password Change
    |--------------------------------------------------------------------------
    */

    $_SESSION = [];

    if (ini_get("session.use_cookies")) {

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );

    }

    session_destroy();

    header(
        "Location: ../auth/login.php?success=Password+changed+successfully.+Please+login+again"
    );

    exit();

} catch (PDOException $e) {

    error_log(
        "Password update error: " . $e->getMessage()
    );

    header(
        "Location: change_password.php?error=An+unexpected+error+occurred.+Please+try+again"
    );

    exit();

}

?>