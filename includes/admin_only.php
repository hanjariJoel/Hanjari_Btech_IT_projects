<?php

require_once __DIR__ . "/session.php";

if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] !== 'admin'
) {
    http_response_code(403);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Access Denied</title>
        <link
            rel="stylesheet"
            href="../assets/css/style.css"
        >
    </head>

    <body>

    <div class="main-content" style="margin-left:0;">

        <div class="card p-5 text-center">

            <i
                class="fa-solid fa-lock"
                style="font-size:50px;color:#A63D2F;margin-bottom:20px;"
            ></i>

            <h2>Access Denied</h2>

            <p>
                You do not have permission to access this page.
            </p>

            <a
                href="../dashboard/dashboard.php"
                class="btn btn-primary"
            >
                <i class="fa-solid fa-house"></i>
                Back to Dashboard
            </a>

        </div>

    </div>

    </body>
    </html>
    <?php
    exit;
}