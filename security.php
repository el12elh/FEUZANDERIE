<?php
    // Security Check
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
        exit('Access Denied');
    }
    if (empty($_SESSION['submit_token'])) {
        $_SESSION['submit_token'] = bin2hex(random_bytes(32));
    }
?>