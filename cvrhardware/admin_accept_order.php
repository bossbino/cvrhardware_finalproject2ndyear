<?php
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/functions.php';

if(empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin'){
    echo "<script>alert('Access denied. Admins only.'); window.location='/index.php';</script>";
    exit;
}

$order_id = intval($_GET['id'] ?? 0);
if($order_id <= 0){
    echo "<script>alert('Invalid order ID'); window.location='/admin_orders.php';</script>";
    exit;
}

$stmt = $conn->prepare("UPDATE orders SET status='Accepted' WHERE id=?");
$stmt->bind_param("i", $order_id);
if($stmt->execute()){
    $stmt->close();
    echo "<script>alert('Order accepted successfully!'); window.location='/admin_orders.php';</script>";
    exit;
}else{
    $stmt->close();
    echo "<script>alert('Failed to accept order.'); window.location='/admin_orders.php';</script>";
    exit;
}

