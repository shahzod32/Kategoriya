<?php
include 'db.php';

$id = $_GET['id'];
$p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

// Kategoriyalarni olish
$categories = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $price    = $_POST['price'];
    $desc     = mysqli_real_escape_string($conn, $_POST['description']);
    $qty      = $_POST['quantity'];
    $cat_id   = $_POST['category_id'];

    $image = $p['image'];
    if ($_FILES['image']['name']) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);
    }

    $sql = "UPDATE products SET 
                name='$name', 
                price='$price', 
                description='$desc', 
                quantity='$qty', 
                image='$image', 
                category_id='$cat_id' 
            WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Xato: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Mahsulotni tahrirlash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4 text-primary">✏️ Mahsulotni tahrirlash</h2>

  <form method="post" enctype="multipart/form-data" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label class="form-label">Nomi</label>
      <input type="text" name="name" value="<?= htmlspecialchars($p['name']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Narxi</label>
      <input type="number" step="0.01" name="price" value="<?= $p['price'] ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Tafsilot</label>
      <textarea name="description" class="form-control"><?= htmlspecialchars($p['description']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Miqdori</label>
      <input type="number" name="quantity" value="<?= $p['quantity'] ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Eski rasm</label><br>
      <?php if ($p['image']): ?>
        <img src="uploads/<?= $p['image'] ?>" width="100" class="rounded shadow-sm mb-2"><br>
      <?php else: ?>
        <span class="text-muted">Rasm yo‘q</span><br>
      <?php endif; ?>
      <input type="file" name="image" class="form-control mt-2">
    </div>

    <div class="mb-3">
      <label class="form-label">Kategoriya</label>
      <select name="category_id" class="form-select" required>
        <?php while($cat = $categories->fetch_assoc()): ?>
          <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $p['category_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="d-flex justify-content-between">
      <button type="submit" class="btn btn-primary">Yangilash</button>
      <a href="index.php" class="btn btn-secondary">Ortga</a>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
