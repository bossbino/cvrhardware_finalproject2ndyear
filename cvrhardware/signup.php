<?php
require_once 'inc/db.php';
session_start();

if(isset($_SESSION['user_id'])){
    header('Location:/index.php');
    exit;
}

$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if(!$fullname || !$email || !$password){
        $error = 'Please fill all fields.';
    } else {
        // Check if email already exists
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if($result_check->num_rows > 0){
            $error = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, 'employee')");
            $stmt->bind_param('sss', $fullname, $email, $hash);
            if($stmt->execute()){
                header('Location: /login.php?registered=1');
                exit;
            } else {
                $error = 'Failed to create account.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up — CVR Hardware</title>
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

/* SIGNUP CARD */
.signup-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    width: 100%;
    max-width: 400px;
    padding: 35px 25px;
    text-align: center;
}

/* HEADINGS */
.signup-card h3 {
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
.btn-signup, .btn-back {
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

.btn-signup {
    background: #001f3f;
    color: #fff;
    border: none;
}
.btn-signup:hover {
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
    .signup-card {
        max-width: 92%;
        padding: 30px 20px;
    }

    .signup-card h3 {
        font-size: 2rem;
    }

    .form-control {
        font-size: 1.15rem;
        padding: 14px;
    }

    .btn-signup, .btn-back {
        font-size: 1.15rem;
        padding: 14px;
    }

    .small-text {
        font-size: 1rem;
    }
}

@media(max-width:480px){
    .signup-card {
        max-width: 95%;
        padding: 25px 15px;
    }

    .signup-card h3 {
        font-size: 2.1rem;
        margin-bottom: 25px;
    }

    .form-control {
        font-size: 1.2rem;
        padding: 16px;
    }

    .btn-signup, .btn-back {
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
<div class="signup-card">
    <h3>Create Account</h3>
    <?php if($error): ?><div class="error-msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <input type="text" class="form-control" name="fullname" placeholder="Full Name" required>
        <input type="email" class="form-control" name="email" placeholder="Email Address" required>
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <button class="btn-signup" type="submit">Sign Up</button>
        <a href="index.php" class="btn-back">Back to Home</a>
    </form>
    <p class="small-text">Already have an account? <a href="/login.php">Log in</a></p>
</div>
</body>
</html>
