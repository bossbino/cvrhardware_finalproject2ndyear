<?php
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products — CVR Hardware</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

<style>
html, body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: #f0f4ff;
    color: #000;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Navbar same as About page */
.navbar {
    padding: 0.8rem 1rem;
}
.navbar-brand img { width: 55px; height: 55px; object-fit: cover; }
.navbar-nav .nav-link { font-size: 1rem; padding: 0.5rem 1rem; }

/* Main content */
main {
    flex: 1 0 auto;
}

/* Products section */
section.products-section {
    padding: 60px 20px;
    text-align: center;
}
.products-section h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #001f3f;
    margin-bottom: 40px;
}

/* Product cards grid */
.products-grid {
    display: grid;
    grid-template-columns: 1fr; /* stacked on mobile */
    gap: 20px;
}

/* Product card */
.product-card {
    display: flex;
    flex-direction: column;
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
    height: 100%;
}
.product-card img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 8px 8px 0 0;
}
.product-info {
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    flex-grow: 1;
}
.product-info h5 { font-size: 1.2rem; font-weight: 600; margin-bottom: 5px; text-align: center; }
.product-info p { font-size: 1rem; font-weight: 700; margin-bottom: 10px; }
.product-info button, .product-info input[type=number] { font-size: 1rem; }

/* Footer same as About page */
footer {
    background:#001f3f;
    color:#fff;
    text-align:center;
    padding: 12px 0;
    font-size: 1rem;
    font-weight: 600;
    margin-top: auto;
}

/* Login popup */
#loginOverlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.55);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 999999;
}
#loginCard {
    width: 380px;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
    animation: popup 0.25s ease-out;
}
@keyframes popup {
    from { transform: scale(0.7); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.close-login { cursor:pointer; }

/* Responsive grid and font sizes */
@media(min-width: 768px){
    .products-grid { grid-template-columns: repeat(2, 1fr); }
}
@media(min-width: 1024px){
    .products-grid { grid-template-columns: repeat(3, 1fr); }
}
@media(max-width:768px){
    .products-section h2 { font-size: 2rem; margin-bottom: 30px; }
    .product-info h5 { font-size: 1rem; }
    .product-info p { font-size: 0.9rem; }
    .product-info button, .product-info input[type=number] { font-size: 0.9rem; }

    footer { font-size: 1.2rem; padding: 20px 0; }
}
</style>
</head>
<body>

<main>
<section class="products-section container">
    <h2 class="fw-bold">Products</h2>
    <div class="products-grid">
    <?php
    $res = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 15");
    while($p = $res->fetch_assoc()):
        $img = !empty($p['image']) ? 'images/' . htmlspecialchars($p['image']) : 'images/placeholder.png';
    ?>
        <div class="product-card">
            <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['name']) ?>">
            <div class="product-info">
                <h5><?= htmlspecialchars($p['name']) ?></h5>
                <p>₱ <?= number_format($p['price'],2) ?></p>
                <?php if(!empty($_SESSION['user_id'])): ?>
                    <form action="/purchase.php" method="GET" style="width: 100%;">
                        <input type="hidden" name="id" value="<?= intval($p['id']) ?>">
                        <input type="number" name="quantity" class="form-control mb-2" min="1" value="1" style="width:100px; display:inline-block;">
                        <button type="submit" class="btn btn-dark w-100 mt-2">Purchase</button>
                    </form>
                <?php else: ?>
                    <button type="button" class="btn btn-primary w-100 mt-2 show-login">Login to Purchase</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
</section>
</main>

<div id="loginOverlay">
    <div id="loginCard">
        <h4 class="text-center mb-3 fw-bold">Login</h4>
        <form action="login.php" method="POST">
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button class="btn btn-dark w-100 mb-3">Login</button>
        </form>
        <button class="btn btn-secondary w-100 close-login">Close</button>
    </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll(".show-login").forEach(btn => {
    btn.addEventListener("click", () => {
        document.getElementById("loginOverlay").style.display = "flex";
    });
});
document.querySelector(".close-login").addEventListener("click", () => {
    document.getElementById("loginOverlay").style.display = "none";
});
document.getElementById("loginOverlay").addEventListener("click", e => {
    if(e.target === e.currentTarget) e.currentTarget.style.display = "none";
});
</script>
</body>
</html>
