<?php


require_once __DIR__ . '/../inc/db.php'; 
require_login(); 

if (!isset($_SESSION)) session_start();

$totalProducts = $conn->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'];
$totalSales = $conn->query("SELECT COUNT(*) as c FROM sales")->fetch_assoc()['c'];
$todaySales = $conn->query("SELECT COALESCE(SUM(total),0) as s FROM sales WHERE DATE(created_at)=CURDATE()")->fetch_assoc()['s'];

$thisMonth = $conn->query("SELECT COALESCE(SUM(total),0) as s FROM sales WHERE YEAR(created_at)=YEAR(CURDATE()) AND MONTH(created_at)=MONTH(CURDATE())")->fetch_assoc()['s'];
$prevMonth = $conn->query("SELECT COALESCE(SUM(total),0) as s FROM sales WHERE YEAR(created_at)=YEAR(DATE_SUB(CURDATE(),INTERVAL 1 MONTH)) AND MONTH(created_at)=MONTH(DATE_SUB(CURDATE(),INTERVAL 1 MONTH))")->fetch_assoc()['s'];

$monthlyChange = 0;
$monthlyChangeLabel = '—';
if ($prevMonth == 0 && $thisMonth > 0) {
    $monthlyChangeLabel = '↑ New sales this month';
} elseif ($prevMonth == 0 && $thisMonth == 0) {
    $monthlyChangeLabel = '—';
} else {
    $monthlyChange = (($thisMonth - $prevMonth) / max(1, $prevMonth)) * 100;
    $monthlyChangeLabel = sprintf('%+.1f%%', $monthlyChange);
}

include __DIR__ . '/../inc/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h1>Dashboard</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text"><?= $totalProducts ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text"><?= $totalSales ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Today's Sales</h5>
                    <p class="card-text"><?= $todaySales ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Monthly Change</h5>
                    <p class="card-text"><?= $monthlyChangeLabel ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
