<?php
require_once __DIR__.'/../inc/functions.php';
requireLogin();
if(!isCustomer()){ exit("Access denied"); }
require_once __DIR__.'/../inc/db.php';

$user_id = getUserId();
$res = $conn->query("SELECT o.id, p.name as product, o.quantity, o.status, o.created_at
FROM orders o
JOIN products p ON o.product_id=p.id
WHERE o.user_id=$user_id ORDER BY o.created_at DESC");

include __DIR__.'/../inc/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Orders — CVR Hardware</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<style>
html, body {
    margin: 0;
    padding: 0;
    font-family: 'Montserrat', sans-serif;
    background-color: #fff;
    color: #001f3f;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Navbar */
.navbar { padding: 0.8rem 1rem; }
.navbar-brand img { width: 55px; height: 55px; object-fit: cover; }
.navbar-nav .nav-link { font-size: 1rem; padding: 0.5rem 1rem; }

/* Wrapper & main content */
.wrapper { display: flex; flex-direction: column; min-height: 100vh; }
.content { 
    flex: 1 0 auto; 
    display: flex; 
    justify-content: center; 
    align-items: center; 
    padding: 40px 20px; 
    text-align: center; 
}
.content .container { 
    width: 100%; 
    max-width: 900px;
}

/* Page title */
h2 { font-weight: 700; margin-bottom: 30px; }

/* Table styling */
table { 
    width: 100%; 
    background-color: #fff; 
    color: #001f3f; 
    border-radius: 10px; 
    font-size: 0.95rem;
    table-layout: auto;
}
table th, table td { text-align: center; vertical-align: middle; padding: 0.5rem; }

/* Footer */
footer { 
    flex-shrink: 0; 
    background:#001f3f; 
    color:#fff; 
    text-align:center; 
    padding:12px 0; 
    font-size:1rem; 
    font-weight:600; 
}

/* Responsive adjustments */
@media(max-width:768px){
    .navbar-brand img { width: 50px; height: 50px; }
    .navbar-nav .nav-link { font-size:0.95rem; padding:0.5rem 0.8rem; }

    h2 { font-size: 1.8rem; margin-bottom: 20px; }
    table { font-size: 0.85rem; }
    table th, table td { padding: 0.3rem 0.2rem; }
    .content { padding: 20px 10px; }
    footer { font-size: 0.95rem; padding: 16px 0; }
}
</style>
</head>
<body>

<div class="wrapper">
<main class="content">
<div class="container">
    <h2 class="fw-bold">My Orders</h2>
    <?php if($res->num_rows === 0): ?>
        <p>You have no orders yet.</p>
    <?php else: ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Ordered At</th>
            </tr>
        </thead>
        <tbody>
        <?php while($o=$res->fetch_assoc()): ?>
            <tr>
                <td><?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['product']) ?></td>
                <td><?= $o['quantity'] ?></td>
                <td><?= $o['status'] ?></td>
                <td><?= $o['created_at'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
</main>

<?php include __DIR__.'/../inc/footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
