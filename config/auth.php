<?php

require_once __DIR__ . "/../includes/session.php";


/*
|--------------------------------------------------------------------------
| REQUIRE LOGIN
|--------------------------------------------------------------------------
*/

function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {

        header(
            "Location: /hanjari_music_house/auth/login.php"
        );

        exit();
    }
}


/*
|--------------------------------------------------------------------------
| REQUIRE ROLE
|--------------------------------------------------------------------------
*/

function requireRole($role)
{
    requireLogin();

    $currentRole = strtolower(
        trim($_SESSION['role'] ?? '')
    );

    $requiredRole = strtolower(
        trim($role)
    );


    if ($currentRole !== $requiredRole) {

        header(
            "Location: /hanjari_music_house/dashboard/dashboard.php"
        );

        exit();
    }
}

?>