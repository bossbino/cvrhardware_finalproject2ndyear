<?php
session_start();

// Check if user clicked "Yes" to confirm logout
if (isset($_POST['confirm_logout']) && $_POST['confirm_logout'] === 'yes') {
    session_unset();
    session_destroy();
    header("Location: /index.php");
    exit;
} elseif (isset($_POST['confirm_logout']) && $_POST['confirm_logout'] === 'no') {
    header("Location: /index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logout — CVR Hardware</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<style>
html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Montserrat', sans-serif;
    background-color: #fff; /* white background as in About/Contact */
    color: #001f3f;
    display: flex;
    justify-content: center;
    align-items: center;
}

.logout-card {
    background: #fff;
    padding: 40px 30px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    max-width: 400px;
    width: 100%;
}

.logout-card h3 {
    color: #001f3f;
    font-weight: 700;
    font-size: 1.8rem;
    margin-bottom: 25px;
}

.logout-card .btn {
    margin: 5px;
    width: 120px;
    font-size: 1rem;
    font-weight: 600;
}

.btn-dark {
    background: #001f3f;
    color: #fff;
    border: none;
}

.btn-dark:hover {
    background: #003366;
}

.btn-muted {
    background: #f0f0f0;
    color: #001f3f;
    border: 2px solid #001f3f;
}

.btn-muted:hover {
    background: #e0e0e0;
}

/* Responsive adjustments */
@media(max-width:768px){
    .logout-card {
        padding: 30px 20px;
    }
    .logout-card h3 {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }
    .logout-card .btn {
        width: 100px;
        font-size: 0.95rem;
    }
}
</style>
</head>
<body>

<div class="logout-card">
    <h3>Do you want to logout?</h3>
    <form method="POST">
        <button type="submit" name="confirm_logout" value="yes" class="btn btn-dark">Yes</button>
        <button type="submit" name="confirm_logout" value="no" class="btn btn-muted">No</button>
    </form>
</div>

</body>
</html>
