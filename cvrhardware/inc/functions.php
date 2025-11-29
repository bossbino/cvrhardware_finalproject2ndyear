<?php
require_once __DIR__ . '/db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if the logged-in user is an admin
 * @return bool
 */
function isAdmin() {
    // Use 'role' only; no need to check 'username'
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Check if the logged-in user is a customer
 * @return bool
 */
function isCustomer() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'customer';
}

/**
 * Require user to be logged in. Redirects to login page if not.
 */
function requireLogin() {
    if (!isset($_SESSION['user_id'])) { // check user_id instead of username
        header('Location: /login.php');
        exit;
    }
}

/**
 * Get the current logged-in user's ID
 * @return int|null
 */
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get full user information from database
 * @param int|null $id Optional. If null, uses currently logged-in user.
 * @return array|null User row or null if not found
 */
function getUserInfo($id = null) {
    global $conn;

    if ($id === null) {
        $id = getUserId();
    }

    if (!$id) return null;

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc() ?: null;
}
?>
