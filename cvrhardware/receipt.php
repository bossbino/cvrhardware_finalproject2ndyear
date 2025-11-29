<?php
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/functions.php';

if (!isset($_SESSION['user_id'])) {
    exit('You must be logged in to view this page.');
}

$order_id = intval($_GET['id'] ?? 0);
if ($order_id <= 0) exit('Invalid order ID');

$res = $conn->query("
    SELECT o.*, p.name AS product_name, p.price AS product_price, u.fullname, u.address, u.contact
    FROM orders o
    JOIN products p ON o.product_id = p.id
    JOIN users u ON o.user_id = u.id
    WHERE o.id=$order_id AND o.user_id=".$_SESSION['user_id']."
");
$order = $res->fetch_assoc();
if (!$order) exit('Order not found');

$address = $_POST['address'] ?? $order['address'] ?? '';
$contact = $_POST['contact'] ?? $order['contact'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$showReceipt = false;

if ($payment_method) {
    $showReceipt = true;

    $stmt = $conn->prepare("UPDATE orders SET address=?, contact=? WHERE id=?");
    $stmt->bind_param("ssi", $address, $contact, $order_id);
    $stmt->execute();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receipt — CVR Hardware</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
<style>
html, body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: #f0f4ff;
    color: #000;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    flex: 1 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
    text-align: center;
}

/* Card styling */
.card {
    background: #fff;
    border-radius: 12px;
    padding: 30px 25px;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.card h2, .card h4 {
    font-weight: 700;
    margin-bottom: 15px;
}

.card p {
    font-size: 1.1rem;
    margin: 6px 0;
}

.card .total {
    font-weight: 700;
    font-size: 1.3rem;
    color: #001f3f;
    margin-top: 15px;
}

/* Buttons */
.btn {
    font-size: 1rem;
    padding: 8px 15px;
}

.btn-dark {
    background: #001f3f;
    color: #fff;
    border: none;
}

.btn-dark:hover { background: #003366; }

.btn-secondary {
    background: #e0e0e0;
    color: #001f3f;
    border: none;
}

.btn-secondary:hover { background: #cfcfcf; }

/* Responsive adjustments */
@media(max-width:768px){
    main { padding: 30px 15px; }
    .card { padding: 25px 20px; }
    .card h2, .card h4 { font-size: 1.8rem; }
    .card p { font-size: 1rem; }
    .btn { font-size: 0.95rem; }
}
</style>
</head>
<body>

<main>
<div class="card">
<?php if (!$showReceipt): ?>
    <h4>Confirm Your Order</h4>
    <form method="POST">
        <p><strong>Name:</strong> <?= htmlspecialchars($order['fullname'] ?? '') ?></p>
        <div class="mb-2">
            <label for="address" class="form-label"><strong>Address:</strong></label>
            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($address) ?>" required>
        </div>
        <div class="mb-2">
            <label for="contact" class="form-label"><strong>Contact:</strong></label>
            <input type="text" class="form-control" id="contact" name="contact" value="<?= htmlspecialchars($contact) ?>" required>
        </div>
        <p><strong>Product:</strong> <?= htmlspecialchars($order['product_name'] ?? '') ?></p>
        <p><strong>Price:</strong> ₱ <?= number_format($order['product_price'] ?? 0,2) ?></p>
        <p><strong>Quantity:</strong> <?= $order['quantity'] ?? 0 ?></p>
        <p class="total"><strong>Total:</strong> ₱ <?= number_format($order['total_price'] ?? 0,2) ?></p>
        <div class="mb-3">
            <label for="payment" class="form-label"><strong>Payment Method:</strong></label>
            <select class="form-select" id="payment" name="payment_method" required>
                <option value="">-- Choose --</option>
                <option value="PayMaya" <?= $payment_method=='PayMaya'?'selected':'' ?>>PayMaya</option>
                <option value="GCash" <?= $payment_method=='GCash'?'selected':'' ?>>GCash</option>
                <option value="COD" <?= $payment_method=='COD'?'selected':'' ?>>Cash on Delivery (COD)</option>
            </select>
        </div>
        <button type="submit" class="btn btn-dark w-100 mb-2">Confirm & View Receipt</button>
        <a href="/products.php" class="btn btn-secondary w-100">Go Back</a>
    </form>
<?php else: ?>
    <h2>Receipt</h2>
    <p><strong>Customer:</strong> <?= htmlspecialchars($order['fullname'] ?? '') ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($address) ?></p>
    <p><strong>Contact:</strong> <?= htmlspecialchars($contact) ?></p>
    <hr>
    <p><strong>Product:</strong> <?= htmlspecialchars($order['product_name'] ?? '') ?></p>
    <p><strong>Price:</strong> ₱ <?= number_format($order['product_price'] ?? 0,2) ?></p>
    <p><strong>Quantity:</strong> <?= $order['quantity'] ?? 0 ?></p>
    <p class="total"><strong>Total:</strong> ₱ <?= number_format($order['total_price'] ?? 0,2) ?></p>
    <p><strong>Estimated Arrival:</strong> <?= date('F d, Y', strtotime(($order['created_at'] ?? date('Y-m-d')). ' +3 days')) ?></p>
    <hr>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status'] ?? '') ?></p>
    <p><strong>Payment Method:</strong> <?= htmlspecialchars($payment_method) ?></p>
    <a href="/products.php" class="btn btn-secondary mt-3 w-100">Back to Products</a>
<?php endif; ?>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
