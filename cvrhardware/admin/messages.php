<?php
require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';
require_login();

if(($_SESSION['role'] ?? '') !== 'admin'){
    http_response_code(403); 
    echo "<!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8'>
        <title>Access Denied</title>
        <style>
            body { font-family: 'Montserrat', sans-serif; background:#001f3f; display:flex; align-items:center; justify-content:center; height:100vh; color:#fff; }
            .message-box { text-align:center; background:#fff; padding:40px; border-radius:15px; box-shadow:0 8px 25px rgba(0,0,0,0.2); color:#001f3f; }
            a { display:inline-block; margin-top:20px; text-decoration:none; color:#fff; background:#6c757d; padding:10px 20px; border-radius:10px; }
        </style>
    </head>
    <body>
        <div class='message-box'>
            <h1>Access Denied</h1>
            <p>You do not have permission to view this page.</p>
            <a href='/admin/dashboard.php'>Go Back to Dashboard</a>
        </div>
    </body>
    </html>";
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])){
    $did = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param('i', $did);
    $stmt->execute();
    $stmt->close();
    header('Location: /admin/messages.php');
    exit;
}

if(isset($_GET['export']) && $_GET['export'] === 'csv'){
    $res = $conn->query("SELECT id,name,email,message,date_sent FROM messages ORDER BY date_sent DESC");
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=messages.csv');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['id','name','email','message','date_sent']);
    while($row = $res->fetch_assoc()){
        $row['message'] = str_replace(["\r","\n"], ['\r','\n'], $row['message']);
        fputcsv($out, [$row['id'],$row['name'],$row['email'],$row['message'],$row['date_sent']]);
    }
    fclose($out);
    exit;
}

$res = $conn->query("SELECT * FROM messages ORDER BY date_sent DESC");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Messages — CVR Hardware</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<style>
html, body {
    height: 100%;
    margin: 0;
    background-color: #001f3f;
    font-family: 'Montserrat', sans-serif;
    color: #fff;
}
.wrapper {
    min-height: 100%;
    display: flex;
    flex-direction: column;
}
.content {
    flex: 1 0 auto;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 80px 20px 40px 20px;
}
.card {
    background: #fff;
    color: #001f3f;
    padding: 30px;
    border-radius: 15px;
    max-width: 1000px;
    width: 100%;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}
.header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 25px;
}
h2 {
    font-weight: 700;
    margin: 0;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
}
table th {
    background: #e9ecef;
    text-align: left;
}
.btn {
    padding: 6px 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}
.btn-secondary {
    background: #6c757d;
    color: white;
}
.btn-secondary:hover {
    background: #5a6268;
    color: white;
}
.back-btn {
    display: inline-block;
    text-decoration: none;
    padding: 6px 12px;
    width: 100px;
    text-align: center;
    background: #6c757d;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
}
.back-btn:hover {
    background: #5a6268;
    color: #fff;
}
.export-btn {
    text-decoration: none;
    padding: 6px 12px;
    width: 120px;
    text-align: center;
    border-radius: 8px;
    background: #6c757d;
    color: #fff;
}
.export-btn:hover {
    background: #5a6268;
    color: #fff;
}
</style>
</head>
<body>
<div class="wrapper">
<main class="content">
<div class="card">

    <div class="header-row">
        <a class="back-btn" href="/index.php">Back</a>
        <h2>Customer Messages</h2>
        <a class="export-btn" href="/admin/messages.php?export=csv">Export CSV</a>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
          <th>Date Sent</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($m = $res->fetch_assoc()): ?>
        <tr>
          <td><?= intval($m['id']) ?></td>
          <td><?= htmlspecialchars($m['name']) ?></td>
          <td><?= htmlspecialchars($m['email']) ?></td>
          <td><?= htmlspecialchars($m['message']) ?></td>
          <td><?= $m['date_sent'] ?></td>
          <td>
            <form method="post" onsubmit="return confirm('Delete message #<?= $m['id'] ?>?')">
              <input type="hidden" name="delete_id" value="<?= $m['id'] ?>">
              <button class="btn btn-secondary">Delete</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

</div>
</main>
</div>
</body>
</html>
