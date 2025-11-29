<?php
require_once __DIR__.'/../inc/db.php';
require_once __DIR__.'/../inc/functions.php';
require_login();

$err = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $qty  = intval($_POST['quantity'] ?? 0);

    $imagePath = null;
    if(!empty($_FILES['image']['name'])){
        $up = $_FILES['image'];
        if($up['error'] === UPLOAD_ERR_OK){
            $info = @getimagesize($up['tmp_name']);
            $allowedExt = ['jpg','jpeg','png','gif','webp'];
            $maxSize = 2 * 1024 * 1024; // 2MB
            $ext = strtolower(pathinfo($up['name'], PATHINFO_EXTENSION));
            if(!$info){
                $err = 'Uploaded file is not a valid image.';
            } elseif(!in_array($ext, $allowedExt)){
                $err = 'Only JPG/PNG/GIF/WEBP allowed.';
            } elseif($up['size'] > $maxSize){
                $err = 'Image too large (max 2MB).';
            } else {
                $destDir = __DIR__ . '/../uploads/products';
                if(!is_dir($destDir)) mkdir($destDir, 0755, true);
                $filename = uniqid('p_') . '.' . $ext;
                $dest = $destDir . '/' . $filename;
                if(move_uploaded_file($up['tmp_name'], $dest)){
                    $imagePath = '/uploads/products/' . $filename;
                } else {
                    $err = 'Failed to move uploaded file.';
                }
            }
        } else {
            $err = 'Image upload error.';
        }
    }

    if(!$err){
        $stmt = $conn->prepare("INSERT INTO products (name,description,price,quantity,image) VALUES (?,?,?,?,?)");
        $stmt->bind_param('ssdiss', $name, $desc, $price, $qty, $imagePath);
        if($stmt->execute()){
            $stmt->close();
            header('Location: /admin/products.php'); exit;
        } else {
            $err = 'Database error: ' . $stmt->error;
            $stmt->close();
        }
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Add Product</title><link rel="stylesheet" href="/css/style.css"></head><body>

<div class="canvas-wrap"><div class="card form">
<h3>Add Product</h3>
<?php if($err): ?><div style="color:#c53030;margin:8px 0" class="small"><?=htmlspecialchars($err)?></div><?php endif; ?>
<form method="POST" enctype="multipart/form-data">
  <input class="input" name="name" placeholder="Name" required>
  <input class="input" name="description" placeholder="Description">
  <input class="input" name="price" type="number" step="0.01" placeholder="Price" required>
  <input class="input" name="quantity" type="number" placeholder="Quantity" required>
  <label class="small">Image (optional)</label>
  <input class="input" name="image" type="file" accept="image/*">
  <button class="btn">Save product</button>
</form>
<p class="small center"><a href="/admin/products.php">Back</a></p>
</div></div>
</body></html>
