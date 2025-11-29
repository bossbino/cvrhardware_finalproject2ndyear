<?php
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/navbar.php';

$sent = false;
$err = '';
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['msg_submit'])){
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if(!$name || !$email || !$message){
        $err = "Please fill all fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO messages (name,email,message,created_at) VALUES (?,?,?,NOW())");
        $stmt->bind_param('sss',$name,$email,$message);
        if($stmt->execute()){
            $sent = true;
        } else {
            $err = "Failed to send message.";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact — CVR Hardware</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<style>
html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Montserrat', sans-serif;
    background-color: #fff; /* white background */
    color: #000;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Navbar */
.navbar { padding: 0.8rem 1rem; }
.navbar-brand img { width: 55px; height: 55px; object-fit: cover; }
.navbar-nav .nav-link { font-size: 1rem; padding: 0.5rem 1rem; }

/* Main content */
main {
    flex: 1 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 60px 20px;
}

/* Contact section */
section.contact-section { max-width: 700px; margin: 0 auto; }
section.contact-section h2 { font-weight: 700; margin-bottom: 20px; font-size: 2.5rem; }
section.contact-section p { font-size: 1.1rem; line-height: 1.8; margin-bottom: 30px; }

/* Buttons */
.btn-dark { margin-top: 15px; font-size: 1rem; }

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

/* Responsive adjustments */
@media(max-width:768px){
    section.contact-section h2 { font-size: 2rem; }
    section.contact-section p { font-size: 1rem; }
    .btn-dark { font-size: 0.95rem; padding: 10px 20px; }
    main { padding: 40px 15px; }
    footer { font-size: 1.2rem; padding: 20px 0; }
}
</style>
</head>
<body>

<main>
<section class="contact-section container">
  <h2 class="fw-bold">Contact Us</h2>
  <p>Email: info@cvrhardware.com | Phone: +63 912 345 6789</p>

  <?php if($sent): ?>
    <div class="alert alert-success">Message sent — we'll contact you soon.</div>
  <?php elseif($err): ?>
    <div class="alert alert-danger"><?=htmlspecialchars($err)?></div>
  <?php endif; ?>

  <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#contactModal">
    Send a message
  </button>

  <div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST">
          <div class="modal-header">
            <h5 class="modal-title">Message to CVR Hardware</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input class="form-control mb-2" name="name" placeholder="Your name" required>
            <input class="form-control mb-2" name="email" type="email" placeholder="Your email" required>
            <textarea class="form-control mb-2" name="message" rows="4" placeholder="Your message" required></textarea>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="msg_submit" value="1">
            <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-dark">Send message</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
</main>

<?php include __DIR__ . '/inc/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
