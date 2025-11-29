<?php
session_start();
require_once __DIR__.'/../inc/db.php';
require_once __DIR__.'/../inc/functions.php';
require_login();


$isAdminNoveneil = ($_SESSION['fullname'] ?? '') === 'noveneil';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $did = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param('i', $did);
    $stmt->execute();
    $stmt->close();
    header('Location: /admin/products.php');
    exit;
}


$res = $conn->query("SELECT * FROM products ORDER BY id DESC");
if (!$res) {
    die("Database query failed: " . $conn->error);
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Products — Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: Arial, sans-serif;
    background: #f8f9fa;
    color: #000;
}
.card {
    margin: 20px auto;
    padding: 20px;
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.table th, .table td {
    padding: 10px;
}
.btn {
    padding: 6px 12px;
}
</style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Products</h3>
            <div>
                <a href="/admin/messages.php" class="btn btn-outline-secondary me-2">Back to Messages</a>
                <a href="/admin/add_product.php" class="btn btn-dark">+ Add Product</a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($p = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td>₱ <?= number_format($p['price'],2) ?></td>
                    <td><?= intval($p['quantity']) ?></td>
                    <td>
                        <a href="/admin/edit_product.php?id=<?= $p['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                        <form method="POST" style="display:inline-block" onsubmit="return confirm('Delete product #<?= $p['id'] ?>?')">
                            <input type="hidden" name="delete_id" value="<?= $p['id'] ?>">
                            <button class="btn btn-dark btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
