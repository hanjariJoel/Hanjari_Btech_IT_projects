<?php

/*
|--------------------------------------------------------------------------
| ADMINISTRATOR AUTHORIZATION
|--------------------------------------------------------------------------
*/

require "../../config/auth.php";

requireRole("Administrator");

require_once "../../config/database.php";


/*
|--------------------------------------------------------------------------
| MESSAGES
|--------------------------------------------------------------------------
*/

$success = $_GET['success'] ?? '';
$error   = $_GET['error'] ?? '';


/*
|--------------------------------------------------------------------------
| FETCH USERS
|--------------------------------------------------------------------------
|
| We deliberately fetch only:
|
| Pending    -> registration requests
| Approved   -> active system users
| Inactive   -> deactivated system users
|
| Rejected users are NOT displayed here.
|
| Their database record is still preserved with status = Rejected.
|
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT
        id,
        full_name,
        username,
        email,
        phone,
        role,
        status,
        created_at
    FROM users
    WHERE LOWER(TRIM(status)) IN ('pending', 'approved', 'inactive')
    ORDER BY created_at DESC
");

$allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| SEPARATE USERS
|--------------------------------------------------------------------------
*/

$pendingUsers = [];
$systemUsers  = [];

foreach ($allUsers as $user) {

    $status = strtolower(
        trim($user['status'] ?? '')
    );

    if ($status === 'pending') {

        $pendingUsers[] = $user;

    } elseif (
        $status === 'approved' ||
        $status === 'inactive'
    ) {

        $systemUsers[] = $user;
    }
}


/*
|--------------------------------------------------------------------------
| STATISTICS
|--------------------------------------------------------------------------
*/

$totalUsers = count($systemUsers);

$administrators = 0;
$storekeepers   = 0;

foreach ($systemUsers as $user) {

    $role = strtolower(
        trim($user['role'] ?? '')
    );

    if (
        $role === 'admin' ||
        $role === 'administrator'
    ) {

        $administrators++;

    } elseif ($role === 'storekeeper') {

        $storekeepers++;
    }
}

$pendingCount = count($pendingUsers);


/*
|--------------------------------------------------------------------------
| CURRENT ADMINISTRATOR
|--------------------------------------------------------------------------
*/

$currentUserId = isset($_SESSION['user_id'])
    ? (int) $_SESSION['user_id']
    : 0;


/*
|--------------------------------------------------------------------------
| PAGE
|--------------------------------------------------------------------------
*/

include "../../includes/header.php";

?>

<div class="wrapper">

    <?php include "../../includes/sidebar.php"; ?>


    <div class="main-content">


        <!-- ==========================================================
             ALERTS
        ========================================================== -->

        <?php if ($success !== ''): ?>

            <div
                class="alert alert-success alert-dismissible fade show mb-4"
                role="alert"
            >

                <i class="fa-solid fa-circle-check me-2"></i>

                <?= htmlspecialchars($success); ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>

            </div>

        <?php endif; ?>


        <?php if ($error !== ''): ?>

            <div
                class="alert alert-danger alert-dismissible fade show mb-4"
                role="alert"
            >

                <i class="fa-solid fa-circle-exclamation me-2"></i>

                <?= htmlspecialchars($error); ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>

            </div>

        <?php endif; ?>


        <!-- ==========================================================
             NAVBAR
        ========================================================== -->

        <?php include "../../includes/navbar.php"; ?>


        <!-- ==========================================================
             PAGE HEADER
        ========================================================== -->

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>

                <h2 class="page-title">

                    <i class="fa-solid fa-users-gear"></i>

                    User Management

                </h2>

                <p class="page-subtitle mb-0">

                    Manage administrators and storekeepers who have access
                    to the system.

                </p>

            </div>


            <a
                href="add_user.php"
                class="btn btn-gold"
            >

                <i class="fa-solid fa-user-plus"></i>

                Add User

            </a>

        </div>


        <!-- ==========================================================
             STATISTICS
        ========================================================== -->

        <div class="row g-4 mb-4">


            <!-- TOTAL USERS -->

            <div class="col-md-4">

                <div class="user-stat-card">

                    <div class="user-stat-icon">

                        <i class="fa-solid fa-users"></i>

                    </div>

                    <div>

                        <span>Total Users</span>

                        <strong>
                            <?= $totalUsers; ?>
                        </strong>

                    </div>

                </div>

            </div>


            <!-- ADMINISTRATORS -->

            <div class="col-md-4">

                <div class="user-stat-card">

                    <div class="user-stat-icon admin">

                        <i class="fa-solid fa-user-shield"></i>

                    </div>

                    <div>

                        <span>Administrators</span>

                        <strong>
                            <?= $administrators; ?>
                        </strong>

                    </div>

                </div>

            </div>


            <!-- STOREKEEPERS -->

            <div class="col-md-4">

                <div class="user-stat-card">

                    <div class="user-stat-icon staff">

                        <i class="fa-solid fa-user-tie"></i>

                    </div>

                    <div>

                        <span>Storekeepers</span>

                        <strong>
                            <?= $storekeepers; ?>
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        <!-- ==========================================================
             PENDING REGISTRATIONS
        ========================================================== -->

        <?php if ($pendingCount > 0): ?>

            <div class="card pending-users-card mb-4">

                <div class="card-header pending-header">

                    <div>

                        <h5>

                            <i class="fa-solid fa-user-clock me-2"></i>

                            Pending Storekeeper Registrations

                        </h5>

                        <small class="text-muted">

                            These registration requests require
                            administrator approval.

                        </small>

                    </div>


                    <span class="pending-count">

                        <?= $pendingCount; ?>

                        Pending

                    </span>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table user-table pending-table mb-0">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Applicant</th>

                                    <th>Username</th>

                                    <th>Email</th>

                                    <th>Phone</th>

                                    <th>Registered</th>

                                    <th class="text-center">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php foreach ($pendingUsers as $index => $user): ?>

                                    <?php

                                    $fullName = trim(
                                        $user['full_name'] ?? ''
                                    );

                                    $initial = $fullName !== ''
                                        ? strtoupper(
                                            substr($fullName, 0, 1)
                                        )
                                        : '?';

                                    ?>

                                    <tr>

                                        <!-- NUMBER -->

                                        <td>
                                            <?= $index + 1; ?>
                                        </td>


                                        <!-- APPLICANT -->

                                        <td>

                                            <div class="user-profile-cell">

                                                <div class="user-avatar-small pending-avatar">

                                                    <?= htmlspecialchars($initial); ?>

                                                </div>

                                                <div>

                                                    <strong>

                                                        <?= htmlspecialchars(
                                                            $fullName
                                                        ); ?>

                                                    </strong>

                                                    <small>
                                                        Storekeeper Applicant
                                                    </small>

                                                </div>

                                            </div>

                                        </td>


                                        <!-- USERNAME -->

                                        <td>

                                            <span class="username-text">

                                                @<?= htmlspecialchars(
                                                    $user['username'] ?? ''
                                                ); ?>

                                            </span>

                                        </td>


                                        <!-- EMAIL -->

                                        <td>

                                            <?= htmlspecialchars(
                                                $user['email']
                                                ?? 'Not provided'
                                            ); ?>

                                        </td>


                                        <!-- PHONE -->

                                        <td>

                                            <?php if (!empty($user['phone'])): ?>

                                                <?= htmlspecialchars(
                                                    $user['phone']
                                                ); ?>

                                            <?php else: ?>

                                                <span class="text-muted">
                                                    Not provided
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- REGISTERED -->

                                        <td>

                                            <?php if (!empty($user['created_at'])): ?>

                                                <?= date(
                                                    "d M Y",
                                                    strtotime(
                                                        $user['created_at']
                                                    )
                                                ); ?>

                                            <?php else: ?>

                                                —

                                            <?php endif; ?>

                                        </td>


                                        <!-- ACTIONS -->

                                        <td>

                                            <div class="user-actions justify-content-center">


                                                <!-- APPROVE -->

                                                <a
                                                    href="approve.php?id=<?= (int)$user['id']; ?>"
                                                    class="btn btn-sm btn-success"
                                                    title="Approve Storekeeper"
                                                    onclick="return confirm('Approve this storekeeper registration?');"
                                                >

                                                    <i class="fa-solid fa-check"></i>

                                                    Approve

                                                </a>


                                                <!-- REJECT -->

                                                <a
                                                    href="reject.php?id=<?= (int)$user['id']; ?>"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Reject Storekeeper"
                                                    onclick="return confirm('Reject this storekeeper registration?');"
                                                >

                                                    <i class="fa-solid fa-xmark"></i>

                                                    Reject

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        <?php endif; ?>


        <!-- ==========================================================
             SYSTEM USERS
        ========================================================== -->

        <div class="card user-management-card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <div>

                    <h5>

                        <i class="fa-solid fa-user-group me-2"></i>

                        System Users

                    </h5>

                    <small class="text-muted">

                        Approved and active system personnel.

                    </small>

                </div>


                <span class="user-count">

                    <?= $totalUsers; ?>

                    User<?= $totalUsers === 1 ? '' : 's'; ?>

                </span>

            </div>


            <div class="card-body p-0">


                <?php if (empty($systemUsers)): ?>

                    <!-- ==================================================
                         EMPTY STATE
                    ================================================== -->

                    <div class="empty-users">

                        <div class="empty-users-icon">

                            <i class="fa-solid fa-users-slash"></i>

                        </div>

                        <h5>
                            No system users found
                        </h5>

                        <p>
                            There are currently no approved or inactive users.
                        </p>

                    </div>


                <?php else: ?>


                    <!-- ==================================================
                         USERS TABLE
                    ================================================== -->

                    <div class="table-responsive">

                        <table class="table user-table mb-0">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>User</th>

                                    <th>Username</th>

                                    <th>Email</th>

                                    <th>Phone</th>

                                    <th>Role</th>

                                    <th>Status</th>

                                    <th>Created</th>

                                    <th class="text-center">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php foreach ($systemUsers as $index => $user): ?>

                                    <?php

                                    $fullName = trim(
                                        $user['full_name'] ?? ''
                                    );

                                    $initial = $fullName !== ''
                                        ? strtoupper(
                                            substr($fullName, 0, 1)
                                        )
                                        : '?';


                                    $role = strtolower(
                                        trim(
                                            $user['role'] ?? ''
                                        )
                                    );


                                    $status = strtolower(
                                        trim(
                                            $user['status'] ?? ''
                                        )
                                    );


                                    $isAdmin = (
                                        $role === 'admin' ||
                                        $role === 'administrator'
                                    );


                                    $isCurrentUser = (
                                        (int)$user['id'] ===
                                        $currentUserId
                                    );

                                    ?>

                                    <tr>


                                        <!-- NUMBER -->

                                        <td>
                                            <?= $index + 1; ?>
                                        </td>


                                        <!-- USER -->

                                        <td>

                                            <div class="user-profile-cell">

                                                <div class="user-avatar-small">

                                                    <?= htmlspecialchars($initial); ?>

                                                </div>

                                                <div>

                                                    <strong>

                                                        <?= htmlspecialchars(
                                                            $fullName
                                                        ); ?>

                                                    </strong>

                                                    <small>
                                                        System User
                                                    </small>

                                                </div>

                                            </div>

                                        </td>


                                        <!-- USERNAME -->

                                        <td>

                                            <span class="username-text">

                                                @<?= htmlspecialchars(
                                                    $user['username'] ?? ''
                                                ); ?>

                                            </span>

                                        </td>


                                        <!-- EMAIL -->

                                        <td>

                                            <?= htmlspecialchars(
                                                $user['email']
                                                ?? 'Not provided'
                                            ); ?>

                                        </td>


                                        <!-- PHONE -->

                                        <td>

                                            <?php if (!empty($user['phone'])): ?>

                                                <?= htmlspecialchars(
                                                    $user['phone']
                                                ); ?>

                                            <?php else: ?>

                                                <span class="text-muted">
                                                    Not provided
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- ROLE -->

                                        <td>

                                            <?php if ($isAdmin): ?>

                                                <span class="role-badge role-admin">

                                                    <i class="fa-solid fa-shield-halved"></i>

                                                    Administrator

                                                </span>

                                            <?php else: ?>

                                                <span class="role-badge role-storekeeper">

                                                    <i class="fa-solid fa-user-tie"></i>

                                                    Storekeeper

                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- STATUS -->

                                        <td>

                                            <?php if ($status === 'approved'): ?>

                                                <span class="status-badge status-approved">

                                                    <i class="fa-solid fa-circle-check"></i>

                                                    Active

                                                </span>

                                            <?php elseif ($status === 'inactive'): ?>

                                                <span class="status-badge status-inactive">

                                                    <i class="fa-solid fa-circle-xmark"></i>

                                                    Inactive

                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- CREATED -->

                                        <td>

                                            <span class="created-date">

                                                <?php if (!empty($user['created_at'])): ?>

                                                    <?= date(
                                                        "d M Y",
                                                        strtotime(
                                                            $user['created_at']
                                                        )
                                                    ); ?>

                                                <?php else: ?>

                                                    —

                                                <?php endif; ?>

                                            </span>

                                        </td>


                                        <!-- ACTIONS -->

                                        <td>

                                            <div class="user-actions justify-content-center">


                                                <!-- EDIT -->

                                                <a
                                                    href="edit.php?id=<?= (int)$user['id']; ?>"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Edit User"
                                                >

                                                    <i class="fa-solid fa-pen"></i>

                                                </a>


                                                <?php if (!$isCurrentUser): ?>


                                                    <!-- ACTIVATE / DEACTIVATE -->

                                                    <form
                                                        method="POST"
                                                        action="toggle_status.php"
                                                        style="display:inline;"
                                                    >

                                                        <input
                                                            type="hidden"
                                                            name="id"
                                                            value="<?= (int)$user['id']; ?>"
                                                        >


                                                        <?php if ($status === 'approved'): ?>

                                                            <button
                                                                type="submit"
                                                                class="btn btn-sm btn-outline-warning"
                                                                title="Deactivate User"
                                                                onclick="return confirm('Deactivate this user? They will no longer be able to log in.');"
                                                            >

                                                                <i class="fa-solid fa-user-slash"></i>

                                                            </button>


                                                        <?php elseif ($status === 'inactive'): ?>

                                                            <button
                                                                type="submit"
                                                                class="btn btn-sm btn-outline-success"
                                                                title="Activate User"
                                                                onclick="return confirm('Activate this user? They will be able to log in again.');"
                                                            >

                                                                <i class="fa-solid fa-user-check"></i>

                                                            </button>

                                                        <?php endif; ?>

                                                    </form>


                                                    <!-- DELETE -->

                                                    <a
                                                        href="delete.php?id=<?= (int)$user['id']; ?>"
                                                        class="btn btn-sm btn-outline-danger delete-btn"
                                                        title="Delete User"
                                                        onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');"
                                                    >

                                                        <i class="fa-solid fa-trash"></i>

                                                    </a>


                                                <?php else: ?>


                                                    <!-- CURRENT ADMIN -->

                                                    <span
                                                        class="current-user-label"
                                                        title="You cannot deactivate or delete your own account."
                                                    >

                                                        <i class="fa-solid fa-user-check"></i>

                                                    </span>

                                                <?php endif; ?>


                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php endif; ?>

            </div>

        </div>


    </div>

</div>


<?php include "../../includes/footer.php"; ?>