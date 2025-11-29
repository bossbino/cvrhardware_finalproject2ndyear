<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userRole = $_SESSION['role'] ?? null;
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background:#001f3f;">
  <div class="container">
    <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="/index.php">
      <img src="/cvr.jpg" width="45" height="45" class="rounded-circle me-2">
      CVR Hardware
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link text-white" href="/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/about.php">About</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/products.php">Products</a></li>

        <?php if($userRole !== 'admin'): ?>
            <li class="nav-item"><a class="nav-link text-white" href="/contact.php">Contact</a></li>
        <?php endif; ?>

        <?php if($userRole === 'admin'): ?>
            <li class="nav-item"><a class="nav-link text-white" href="/admin/messages.php">Messages</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="/admin/index.php">Admin Panel</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="/logout.php">Logout</a></li>

        <?php elseif($userRole === 'customer'): ?>
            <li class="nav-item"><a class="nav-link text-white" href="/customer/orders.php">My Orders</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="/logout.php">Logout</a></li>

        <?php else: ?>
            <li class="nav-item"><a class="nav-link text-white" href="/login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="/signup.php">Sign Up</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<style>
/* Thinner navbar adjustments */
.navbar {
    padding-top: 0.3rem;
    padding-bottom: 0.3rem;
}

.navbar-brand img {
    width: 40px; /* smaller logo */
    height: 40px;
    object-fit: cover;
}

.navbar-nav .nav-item .nav-link {
    padding: 0.3rem 0.8rem; /* thinner nav links */
    font-size: 0.95rem;
}
</style>
