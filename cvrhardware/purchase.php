<?php
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/functions.php';

// check login
if(empty($_SESSION['user_id'])){
    echo "<script>alert('Please login first to purchase.'); window.location='/index.php';</script>";
    exit;
}

$product_id = intval($_GET['id'] ?? 0);
$quantity = intval($_GET['quantity'] ?? 1);

if($product_id <= 0){
    exit('Invalid product ID');
}

// get product
$res = $conn->query("SELECT * FROM products WHERE id=$product_id");
$product = $res->fetch_assoc();
if(!$product) exit('Product not found');

// calculate total
$total = $quantity * $product['price'];

// insert order
$stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, total_price, status, created_at) VALUES (?, ?, ?, ?, 'Pending', NOW())");
$stmt->bind_param("iiid", $_SESSION['user_id'], $product_id, $quantity, $total);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// redirect to receipt
header("Location: /receipt.php?id=$order_id");
exit;
