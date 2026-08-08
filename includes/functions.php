<?php

/**
 * Count all records in a table
 */
function countRecords($pdo, $table)
{
    $allowedTables = [
        'users',
        'categories',
        'suppliers',
        'instruments',
        'stock_transactions',
        'system_logs'
    ];

    // Prevent SQL injection by allowing only known tables
    if (!in_array($table, $allowedTables)) {
        return 0;
    }

    $sql = "SELECT COUNT(*) FROM $table";
    return $pdo->query($sql)->fetchColumn();
}

/**
 * Count instruments with low stock
 */
function getLowStockCount($pdo)
{
    $sql = "SELECT COUNT(*) FROM instruments WHERE quantity <= 5";
    return $pdo->query($sql)->fetchColumn();
}

/**
 * Get recent stock transactions
 */
function getRecentActivities($pdo, $limit = 5)
{
    $sql = "
        SELECT
            st.*,
            i.instrument_name
        FROM stock_transactions st
        INNER JOIN instruments i
            ON st.instrument_id = i.id
        ORDER BY st.created_at DESC
        LIMIT :limit
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}