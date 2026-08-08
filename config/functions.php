<?php

/**
 * Count records from approved tables only.
 */
function countRecords(PDO $pdo, string $table): int
{
    $allowedTables = [
        'users',
        'categories',
        'suppliers',
        'instruments',
        'stock_transactions',
        'system_logs'
    ];

    if (!in_array($table, $allowedTables, true)) {
        return 0;
    }

    $stmt = $pdo->query("SELECT COUNT(*) FROM `$table`");

    return (int) $stmt->fetchColumn();
}


/**
 * Count instruments with low stock.
 */
function getLowStockCount(PDO $pdo): int
{
    $stmt = $pdo->query(
        "SELECT COUNT(*) FROM instruments WHERE quantity <= 5"
    );

    return (int) $stmt->fetchColumn();
}


/**
 * Get recent stock transactions.
 */
function getRecentActivities(PDO $pdo, int $limit = 5): array
{
    $limit = max(1, min($limit, 50));

    $sql = "
        SELECT
            st.id,
            st.instrument_id,
            st.transaction_type,
            st.quantity,
            st.reference_no,
            st.transaction_date,
            st.remarks,
            st.created_at,
            i.instrument_name
        FROM stock_transactions st
        INNER JOIN instruments i
            ON st.instrument_id = i.id
        ORDER BY st.created_at DESC, st.id DESC
        LIMIT $limit
    ";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Find a user by ID.
 */
function getUserById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare("
        SELECT id, full_name, username, role, created_at
        FROM users
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ?: null;
}


/**
 * Count administrator accounts.
 */
function getAdminCount(PDO $pdo): int
{
    $stmt = $pdo->query("
        SELECT COUNT(*)
        FROM users
        WHERE role = 'admin'
    ");

    return (int) $stmt->fetchColumn();
}


/**
 * Count storekeeper accounts.
 */
function getStorekeeperCount(PDO $pdo): int
{
    $stmt = $pdo->query("
        SELECT COUNT(*)
        FROM users
        WHERE role = 'storekeeper'
    ");

    return (int) $stmt->fetchColumn();
}