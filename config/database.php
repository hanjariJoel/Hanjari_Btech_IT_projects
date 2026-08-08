<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Hanjari's Music House
| Database Configuration
|--------------------------------------------------------------------------
*/

$host = "localhost";
$dbname = "hanjari_music_house_db";
$username = "root";
$password = "";

try {

    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ]
    );

} catch (PDOException $e) {

    error_log("Database Connection Error: " . $e->getMessage());

    http_response_code(500);

    die(
        "Unable to connect to the database. " .
        "Please check the database configuration."
    );

}
?>