<?php
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/navbar.php';

if(empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin'){
    echo "<script>alert('Access denied. Admins only.'); window.location='/index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Orders — CVR Hardware</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f0f4ff;">
<div class="container py-5">
<h2 class="fw-bold mb-4">All Customer Orders</h2>

<?php
$res = $conn->query("
    SELECT o.*, p.name AS product_name, u.fullname, u.address, u.contact
    FROM orders o
    JOIN products p ON o.product_id = p.id
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
");
?>
<table class="table table-striped">
<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Product</th>
<th>Quantity</th>
<th>Total</th>
<th>Status</th>
<th>Action</th>
</tr>
<?php while($order = $res->fetch_assoc()): ?>
<tr>
<td><?= $order['id'] ?></td>
<td><?= htmlspecialchars($order['fullname']) ?></td>
<td><?= htmlspecialchars($order['product_name']) ?></td>
<td><?= $order['quantity'] ?></td>
<td>₱ <?= number_format($order['total_price'],2) ?></td>
<td><?= htmlspecialchars($order['status']) ?></td>
<td>
    <?php if($order['status'] === 'Pending'): ?>
        <a href="/admin_accept_order.php?id=<?= $order['id'] ?>" class="btn btn-success btn-sm">Accept</a>
    <?php else: ?>
        <span class="text-success fw-bold">Accepted</span>
    <?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>
<?php include __DIR__ . '/inc/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
