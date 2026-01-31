<?php
session_start();

// Database connection
require_once 'db.php';

// Fetch data (Your existing SQL query)
$tr_stmt = $pdo->prepare("
    SELECT 
        'TOPUP' AS TYPE,
        CONCAT(c.FIRST_NAME, ' ', c.LAST_NAME) AS CUSTOMER,
        r.NAME AS LABEL,
        t.AMOUNT AS AMOUNT,
        t.CREATED_AT,
        CONCAT(a.FIRST_NAME, ' ', a.LAST_NAME) AS BY_NAME
    FROM wallet_topup t
    JOIN customers c ON t.ID_CUSTOMER = c.ID_CUSTOMER
    LEFT JOIN users_customers uc ON t.ID_USER = uc.ID_USER
    LEFT JOIN customers a ON uc.ID_CUSTOMER = a.ID_CUSTOMER
    LEFT JOIN ref_topup_type r ON t.ID_TOPUP_TYPE = r.ID_TOPUP_TYPE
    UNION ALL
    SELECT 
        'PURCHASE' AS TYPE,
        CONCAT(c.FIRST_NAME, ' ', c.LAST_NAME) AS CUSTOMER,
        CONCAT(tr.QUANTITY, 'x', p.NAME) AS LABEL,
        -(p.PRICE * tr.QUANTITY) AS AMOUNT,
        tr.CREATED_AT,
        CONCAT(a.FIRST_NAME, ' ', a.LAST_NAME) AS BY_NAME
    FROM transactions tr
    JOIN customers c ON tr.ID_CUSTOMER = c.ID_CUSTOMER
    LEFT JOIN users_customers uc ON tr.ID_USER = uc.ID_USER
    LEFT JOIN customers a ON uc.ID_CUSTOMER = a.ID_CUSTOMER
    LEFT JOIN ref_product p ON tr.ID_PRODUCT = p.ID_PRODUCT
    ORDER BY CREATED_AT DESC, CUSTOMER
");
$tr_stmt->execute();
$tr = $tr_stmt->fetchAll(PDO::FETCH_ASSOC);

// --- CSV GENERATION START ---

$filename = "transactions_" . date('YmdHis') . ".csv";

// Clear any previous output to prevent file corruption
if (ob_get_length()) ob_end_clean();

// Set headers to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '";');

// Open the output stream
$output = fopen('php://output', 'w');

// 1. Optional: Add UTF-8 BOM for Excel compatibility (Fixes weird characters in Excel)
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// 2. Write the Column Headers
fputcsv($output, array('Type', 'Member', 'Details', 'Amount', 'Date', 'By'));

// 3. Write the Data Rows
foreach ($tr as $row) {
    fputcsv($output, $row);
}

// Close the stream
fclose($output);
exit;