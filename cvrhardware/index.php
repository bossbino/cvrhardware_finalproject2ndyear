<?php
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/functions.php';
$isAdminNoveneil = ($_SESSION['fullname'] ?? '') === 'noveneil';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CVR Hardware Construction Supplies</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

html, body {
    margin: 0;
    padding: 0;
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
    background: #f0f4ff;
    color: #000;
}


main {
    flex: 1 0 auto;
    display: flex;
    flex-direction: column;
}

/* HERO section */
.hero { 
    background:#001f3f;
    flex: 1;
    display: flex; 
    align-items: center; 
    justify-content: center; 
    color: #fff; 
    text-align: center; 
    position: relative;
    overflow: hidden;
    min-height: calc(100vh - 55px); /* subtract navbar height */
    padding-bottom: 20px; /* reduce extra space at bottom */
}

.hero img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover;
    position: absolute; 
    top: 0; 
    left: 0; 
    z-index: 1; 
    opacity: 0.45;
}

.hero .hero-content { 
    z-index: 2; 
    max-width: 900px; 
    padding: 20px; 
}

.hero h1 { font-size: 3rem; font-weight: 700; }
.hero h2 { font-size: 2rem; font-weight: 500; margin-top: 15px; }
.hero p  { font-size: 1.1rem; }

/* Mobile adjustments */
@media(max-width:768px){
    .hero {
        min-height: auto; 
        height: auto; 
        padding: 70px 20px;
    }
    .hero img { height: 100vh; }
    .hero h1 { font-size: 2.2rem; }
    .hero h2 { font-size: 1.4rem; }
    .hero p  { font-size: 1rem; }
}

/* Buttons */
.btn-main {
    background: grey;
    color: #fff;
    border: none;
    padding: 12px 30px;
    font-weight: 500;
    border-radius: 5px;
    text-decoration: none;
}
.btn-main:hover { background: #339cff; }

/* Footer */
footer {
    background:#001f3f;
    color:#fff;
    text-align:center;
    padding: 6px 0; /* thinner footer */
    margin-top: auto; /* stick footer to bottom */
}
</style>
</head>
<body>

<?php include __DIR__ . '/inc/navbar.php'; ?>

<main>
<section id="home" class="hero">
    <img src="cVr.jpg" alt="Hero image">
    <div class="hero-content">
        <h1>CVR Hardware Construction Supplies</h1>
        <h2>Welcome</h2>
        <p>Providing affordable and quality construction materials for builders and DIY projects with fast delivery and reliable service.</p>
        <a href="/products.php" class="btn-main mt-3">Browse Products</a>
    </div>
</section>
</main>

<?php include __DIR__ . '/inc/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
