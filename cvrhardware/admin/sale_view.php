<?php
require_once __DIR__.'/../inc/db.php';
require_once __DIR__.'/../inc/functions.php';
require_login();
$id = intval($_GET['id'] ?? 0);
$s = $conn->query("SELECT * FROM sales WHERE id = $id")->fetch_assoc();
$items = $conn->query("SELECT si.*, p.name FROM sale_items si JOIN products p ON p.id=si.product_id WHERE si.sale_id = $id");
if(!$s) { header('Location:/admin/sales.php'); exit; }
?>
<!doctype html><html><head><meta charset="utf-8"><title>Sale #<?=$s['id']?></title><link rel="stylesheet" href="/css/style.css"></head><body>
<div class="canvas-wrap"><div class="card">
  <div class="header"><div class="brand">Sale #<?=$s['id']?></div><div class="nav"><a href="/admin/sales.php">Back</a></div></div>
  <div class="small">Customer: <?=htmlspecialchars($s['customer_name']?:'Guest')?></div>
  <table class="table" style="margin-top:12px">
    <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Amount</th></tr></thead>
    <tbody>
      <?php while($it = $items->fetch_assoc()): ?>
      <tr>
        <td><?=htmlspecialchars($it['name'])?></td>
        <td>₱ <?=number_format($it['price'],2)?></td>
        <td><?=$it['qty']?></td>
        <td>₱ <?=number_format($it['amount'],2)?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <div style="text-align:right;font-weight:700;margin-top:8px">Total: ₱ <?=number_format($s['total'],2)?></div>
</div></div></body></html>
