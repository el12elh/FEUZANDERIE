<?php
    // Security Check
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
        exit('Access Denied');
    }
?>