<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$DB_HOST = "sql100.infinityfree.com";
$DB_USER = "if0_40273998";
$DB_PASS = "nwLyJ8ZaAx6hyzE";
$DB_NAME = "if0_40273998_cvr_hardware";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_errno) {
    die('DB connect error: '. $conn->connect_error);
}
$conn->set_charset('utf8mb4');

if (session_status() === PHP_SESSION_NONE);

function is_logged() { 
    return isset($_SESSION['user_id']); 
}

function require_login() { 
    if(!is_logged()) { 
        header('Location: /login.php'); 
        exit; 
    } 
}
?>
