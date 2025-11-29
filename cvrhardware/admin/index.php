<?php
require_once __DIR__.'/../inc/functions.php';
require_once __DIR__.'/../inc/db.php';

// Ensure user is logged in
requireLogin();

// Only allow admin
if (!isAdmin()) {
    header("Location: /login.php");
    exit;
}

// Fetch orders
$res = $conn->query("
    SELECT o.id, u.fullname, p.name as product, o.quantity, o.status, o.created_at
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN products p ON o.product_id = p.id
    ORDER BY o.created_at DESC
");

// Include main navbar
include __DIR__.'/../inc/navbar.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel — CVR Hardware</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
            font-family: 'Montserrat', sans-serif;
            background: #f0f4ff;
        }

        /* Navbar */
        .navbar {
            padding: 1rem 1.5rem;
        }

        .navbar-brand img {
            width: 90px;
            height: 90px;
            object-fit: cover;
        }

        .navbar-nav .nav-link {
            font-size: 1.4rem;
            font-weight: 700;
            padding: 0.6rem 1rem;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        h2 {
            font-weight: 900;
            font-size: 3rem;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.4rem;
        }

        th, td {
            padding: 14px 10px;
            text-align: left;
        }

        th {
            background-color: #001f3f;
            color: #fff;
            font-weight: 700;
        }

        tr:nth-child(even) {
            background-color: #e9efff;
        }

        .btn-sm {
            font-size: 1.2rem;
            padding: 10px 16px;
        }

        footer {
            background: #001f3f;
            color: #fff;
            text-align: center;
            font-size: 1.3rem;
            font-weight: 700;
            padding: 18px 0;
            margin-top: 40px;
        }

        /* ================= MOBILE ONLY ================= */
        @media(max-width:768px){
            html, body {
                font-size: 1.3rem;
            }

            .navbar-brand img {
                width: 110px;
                height: 110px;
            }

            .navbar-nav .nav-link {
                font-size: 1.6rem;
                font-weight: 800;
                padding: 0.5rem 0.8rem;
            }

            .container {
                padding: 20px 15px;
            }

            h2 {
                font-size: 3.5rem;
                font-weight: 900;
                margin-bottom: 25px;
            }

            table {
                font-size: 1.6rem;
            }

            th, td {
                padding: 14px 8px;
            }

            .btn-sm {
                font-size: 1.4rem;
                padding: 12px 18px;
            }

            footer {
                font-size: 1.4rem;
                font-weight: 800;
                padding: 20px 0;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }

        @media(max-width:480px){
            h2 {
                font-size: 4rem;
            }

            table {
                font-size: 1.8rem;
            }

            th, td {
                padding: 16px 8px;
            }

            .btn-sm {
                font-size: 1.5rem;
                padding: 14px 20px;
            }

            .navbar-brand img {
                width: 120px;
                height: 120px;
            }

            .navbar-nav .nav-link {
                font-size: 1.7rem;
                font-weight: 900;
            }

            footer {
                font-size: 1.5rem;
                padding: 22px 0;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Customer Orders</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Status</th>
            <th>Ordered At</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while($o = $res->fetch_assoc()): ?>
            <tr>
                <td><?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['fullname']) ?></td>
                <td><?= htmlspecialchars($o['product']) ?></td>
                <td><?= $o['quantity'] ?></td>
                <td><?= $o['status'] ?></td>
                <td><?= $o['created_at'] ?></td>
                <td>
                    <?php if($o['status'] == 'Pending'): ?>
                        <a href="update_order.php?id=<?= $o['id'] ?>&status=Accepted" class="btn btn-success btn-sm">Accept</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include __DIR__.'/../inc/footer.php'; ?>
</body>
</html>
