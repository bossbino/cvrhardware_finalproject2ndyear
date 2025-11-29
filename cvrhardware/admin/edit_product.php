<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_login();

if(($_SESSION['role'] ?? '') !== 'admin'){
    exit('Access denied');
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])){
    $did = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param('i', $did);
    $stmt->execute();
    $stmt->close();
    header('Location: /admin/edit_product.php');
    exit;
}

$res = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin — Edit Products</title>
<link rel="stylesheet" href="/css/style.css">
<style>
table { width:100%; border-collapse: collapse; }
th, td { padding:8px; border-bottom:1px solid #ccc; }
.btn { padding:5px 10px; margin-right:5px; }
</style>
</head>
<body>

<h2>Manage Products</h2>
<a href="/admin/add_product.php">+ Add Product</a>
<table>
<thead>
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Price</th>
  <th>Quantity</th>
  <th>Actions</th>
</tr>
</thead>
<tbody>
<?php while($p = $res->fetch_assoc()): ?>
<tr>
  <td><?= $p['id'] ?></td>
  <td><?= htmlspecialchars($p['name']) ?></td>
  <td>₱<?= number_format($p['price'],2) ?></td>
  <td><?= intval($p['quantity']) ?></td>
  <td>
    <a href="/admin/edit_product_form.php?id=<?= $p['id'] ?>">Edit</a>
    <form method="post" style="display:inline-block" onsubmit="return confirm('Delete product #<?= $p['id'] ?>?')">
      <input type="hidden" name="delete_id" value="<?= $p['id'] ?>">
      <button class="btn">Delete</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</body>
</html>
