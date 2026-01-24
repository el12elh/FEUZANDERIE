<?php

// 1. Clear all session variables
session_unset();

// 2. Destroy the session itself
session_destroy();

// 3. Clear the session cookie (optional but recommended for security)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Redirect to home
header("Location: ./");
exit();