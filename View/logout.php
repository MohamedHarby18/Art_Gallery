<?php
// File: View/logout.php

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Unset all session variables
$_SESSION = array();

// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Show logout message and redirect via HTML meta refresh
echo '<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="1;url=registration.php">
</head>
<body>
    ✅ Logout successful! Redirecting to registration page...
</body>
</html>';
exit;
?>