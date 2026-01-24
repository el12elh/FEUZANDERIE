<?php
    // Fetch products
    $all_prods = $pdo
        ->query("SELECT * FROM ref_product ORDER BY IS_ACTIVE DESC, NAME")
        ->fetchAll();

    // GET only below
    $customers = $pdo
        ->query("SELECT * FROM customers ORDER BY IS_ACTIVE DESC, BALANCE, LAST_NAME, FIRST_NAME")
        ->fetchAll();

    // Fetch Users NOT yet linked to any customer
    $unlinked_users = $pdo->query("
        SELECT u.ID_USER, u.EMAIL 
        FROM users u 
        LEFT JOIN users_customers uc ON u.ID_USER = uc.ID_USER
        WHERE uc.ID_USER IS NULL
        ORDER BY u.EMAIL
    ")->fetchAll();

    // Fetch Customers and their linked Email (if any)
    $all_customers = $pdo->query("
        SELECT c.ID_CUSTOMER, c.FIRST_NAME, c.LAST_NAME, u.ID_USER AS LINKED_USER_ID, u.EMAIL, u.IS_ADMIN 
        FROM customers c
        LEFT JOIN users_customers uc ON c.ID_CUSTOMER = uc.ID_CUSTOMER
        LEFT JOIN users u ON uc.ID_USER = u.ID_USER
        ORDER BY u.IS_ADMIN, c.LAST_NAME, c.FIRST_NAME
    ")->fetchAll();

    // Fetch data for dropdowns and tables
    $customers_1 = $pdo->query("SELECT ID_CUSTOMER, FIRST_NAME, LAST_NAME, BALANCE FROM customers WHERE IS_ACTIVE = 1 ORDER BY LAST_NAME, FIRST_NAME")->fetchAll();
    $customers_2 = $pdo->query("SELECT ID_CUSTOMER, FIRST_NAME, LAST_NAME, BALANCE FROM customers WHERE IS_ACTIVE = 1 OR BALANCE < 0 ORDER BY LAST_NAME, FIRST_NAME")->fetchAll();
    $products = $pdo->query("SELECT * FROM ref_product WHERE IS_ACTIVE = 1 ORDER BY NAME")->fetchAll();
    $topup_types = $pdo->query("SELECT * FROM ref_topup_type WHERE NAME != 'INITIAL' ORDER BY ID_TOPUP_TYPE")->fetchAll();

    // Fetch data (Your existing SQL query)
    $tr_stmt = $pdo->prepare("
        SELECT
            CONCAT(LEFT(c.FIRST_NAME,1), '. ', c.LAST_NAME) AS CUSTOMER,
            t.AMOUNT AS AMOUNT,
            r.NAME AS LABEL,
            t.CREATED_AT,
            CONCAT(LEFT(a.FIRST_NAME,1), '. ', a.LAST_NAME) AS BY_NAME
        FROM wallet_topup t
        JOIN customers c ON t.ID_CUSTOMER = c.ID_CUSTOMER
        LEFT JOIN users_customers uc ON t.ID_USER = uc.ID_USER
        LEFT JOIN customers a ON uc.ID_CUSTOMER = a.ID_CUSTOMER
        LEFT JOIN ref_topup_type r ON t.ID_TOPUP_TYPE = r.ID_TOPUP_TYPE
        UNION ALL
        SELECT
            CONCAT(LEFT(c.FIRST_NAME,1), '. ', c.LAST_NAME) AS CUSTOMER,
            -(p.PRICE * tr.QUANTITY) AS AMOUNT,
            CONCAT(tr.QUANTITY, 'x', p.NAME) AS LABEL,
            tr.CREATED_AT,
            CONCAT(LEFT(a.FIRST_NAME,1), '. ', a.LAST_NAME) AS BY_NAME
        FROM transactions tr
        JOIN customers c ON tr.ID_CUSTOMER = c.ID_CUSTOMER
        LEFT JOIN users_customers uc ON tr.ID_USER = uc.ID_USER
        LEFT JOIN customers a ON uc.ID_CUSTOMER = a.ID_CUSTOMER
        LEFT JOIN ref_product p ON tr.ID_PRODUCT = p.ID_PRODUCT

        ORDER BY CREATED_AT DESC, CUSTOMER
        LIMIT 10
        ");
    $tr_stmt->execute();
    $transaction = $tr_stmt->fetchAll(PDO::FETCH_ASSOC);
?>