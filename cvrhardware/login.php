<?php
require_once 'inc/db.php';
require_once 'inc/functions.php'; // already starts session

// Redirect already logged-in users
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: /admin/index.php");
    } else {
        header("Location: /index.php");
    }
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, fullname, role, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['email'] = $email;

            if ($row['role'] === 'admin') {
                header("Location: /admin/index.php");
            } else {
                header("Location: /index.php");
            }
            exit;
        } else {
            $error = "Invalid credentials";
        }
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — CVR Hardware</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<style>
html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Montserrat', sans-serif;
    background-color: #001f3f;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* LOGIN CARD */
.login-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    width: 100%;
    max-width: 400px;
    padding: 35px 25px;
    text-align: center;
}

/* HEADINGS */
.login-card h3 {
    color: #001f3f;
    font-weight: 700;
    font-size: 1.8rem;
    margin-bottom: 30px;
}

/* FORM INPUTS */
.form-control {
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 16px;
    font-size: 1.05rem;
}

/* BUTTONS */
.btn-login, .btn-back {
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    font-weight: bold;
    margin-top: 12px;
    font-size: 1.05rem;
    text-decoration: none;
    display: inline-block;
    box-sizing: border-box;
}

.btn-login {
    background: #001f3f;
    color: #fff;
    border: none;
}
.btn-login:hover {
    background: #003366;
}

.btn-back {
    background: #fff;
    color: #001f3f;
    border: 2px solid #001f3f;
}
.btn-back:hover {
    background: #f0f0f0;
}

.error-msg {
    color: #c53030;
    margin-bottom: 16px;
    font-size: 0.95rem;
}

.small-text {
    margin-top: 12px;
    font-size: 0.9rem;
}

/* RESPONSIVE FOR TABLETS & PHONES */
@media(max-width:768px){
    .login-card {
        max-width: 92%;
        padding: 30px 20px;
    }

    .login-card h3 {
        font-size: 2rem;
    }

    .form-control {
        font-size: 1.15rem;
        padding: 14px;
    }

    .btn-login, .btn-back {
        font-size: 1.15rem;
        padding: 14px;
    }

    .small-text {
        font-size: 1rem;
    }
}

@media(max-width:480px){
    .login-card {
        max-width: 95%;
        padding: 25px 15px;
    }

    .login-card h3 {
        font-size: 2.1rem;
        margin-bottom: 25px;
    }

    .form-control {
        font-size: 1.2rem;
        padding: 16px;
    }

    .btn-login, .btn-back {
        font-size: 1.2rem;
        padding: 16px;
    }

    .small-text {
        font-size: 1.05rem;
    }
}
</style>
</head>
<body>
<div class="login-card">
    <h3>Login</h3>
    <?php if($error): ?><div class="error-msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST" action="/login.php">
        <input class="form-control" type="email" name="email" placeholder="Email Address" required>
        <input class="form-control" type="password" name="password" placeholder="Password" required>
        <button class="btn-login" type="submit">Login</button>
        <a href="/index.php" class="btn-back">Back to Home</a>
    </form>
    <p class="small-text">Don't have an account? <a href="/signup.php">Sign up</a></p>
</div>
</body>
</html>
