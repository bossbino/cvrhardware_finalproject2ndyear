<?php
require_once __DIR__.'/../inc/functions.php';
requireLogin();
if(!isAdmin()){ exit("Access denied"); }
require_once __DIR__.'/../inc/db.php';

$id = intval($_GET['id'] ?? 0);
$status = $_GET['status'] ?? '';

if($id && in_array($status,['Accepted','Delivered'])){
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si",$status,$id);
    $stmt->execute();
    $stmt->close();
}

header("Location: index.php");
exit;
?>
