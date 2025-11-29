<?php
require_once __DIR__.'/../inc/db.php';
require_once __DIR__.'/../inc/functions.php';
require_login();
$res = $conn->query("SELECT s.*, u.fullname FROM sales s LEFT JOIN users u ON u.id = s.user_id ORDER BY s.created_at DESC");
?>
<!doctype html><html><head><meta charset="utf-8"><title>Sales</title><link rel="stylesheet" href="/css/style.css"></head><body>
<div class="canvas-wrap"><div class="card">
  <div class="header"><div class="brand">Sales</div><div class="nav"><a href="/admin/dashboard.php">Dashboard</a><a href="/logout.php">Logout</a></div></div>
  <table class="table">
    <thead><tr><th>ID</th><th>Customer</th><th>Total</th><th>Date</th><th>Action</th></tr></thead>
    <tbody>
      <?php while($r = $res->fetch_assoc()): ?>
      <tr>
        <td><?=$r['id']?></td>
        <td><?=htmlspecialchars($r['customer_name']?:'Guest')?></td>
        <td>₱ <?=number_format($r['total'],2)?></td>
        <td><?=$r['created_at']?></td>
        <td><a class="link" href="/admin/sale_view.php?id=<?=$r['id']?>">View</a></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div></div></body></html>
