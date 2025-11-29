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
<title>About — CVR Hardware</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<style>
html, body {
    margin: 0;
    padding: 0;
    font-family: 'Montserrat', sans-serif;
    background-color: #fff;
    color: #000;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Navbar */
.navbar { padding: 0.8rem 1rem; }
.navbar-brand img { width: 55px; height: 55px; object-fit: cover; }
.navbar-nav .nav-link { font-size: 1rem; padding: 0.5rem 1rem; }

/* Main content centered */
main {
    flex: 1 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 40px 20px;
}

/* About Section */
.hero-about {
    max-width: 700px;
}
.hero-about h1 { font-size: 2.5rem; font-weight: 700; margin-bottom: 20px; }
.hero-about h2 { font-size: 1.8rem; font-weight: 500; margin-bottom: 20px; }
.hero-about p  { font-size: 1.1rem; line-height: 1.6; }

/* Footer */
footer {
    background:#001f3f;
    color:#fff;
    text-align:center;
    padding: 12px 0;
    font-size: 1rem;
    font-weight: 600;
    margin-top: auto;
}

/* Responsive adjustments for smaller devices */
@media(max-width:768px){
    .navbar-brand img { width: 65px; height: 65px; } /* slightly smaller */
    .navbar-nav .nav-link { font-size:1rem; padding:0.6rem 0.8rem; } /* slightly smaller */

    .hero-about h1 { font-size: 2.2rem; }
    .hero-about h2 { font-size: 1.6rem; }
    .hero-about p  { font-size: 1rem; line-height: 1.4; }

    footer { font-size: 1.2rem; padding: 20px 0; }
}
</style>
</head>
<body>

<main>
<section class="hero-about container">
    <h1>ABOUT CVR HARDWARE</h1>
    <h2>Your Trusted Construction Supplier</h2>
    <p>
        CVR Hardware Construction Supplies is a local supplier of construction materials and hand tools serving nearby barangays and surrounding areas. Customers can view products, place purchases, and track orders online. Our goal is to provide high-quality materials with fast delivery and reliable service.
    </p>
</section>
</main>

<?php include __DIR__ . '/inc/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
