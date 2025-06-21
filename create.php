<?php include 'db.php';

// POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    $qty   = $_POST['quantity'];
    $catId = $_POST['category_id'];

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);
    }

    $sql = "INSERT INTO products (name, price, description, image, quantity, category_id)
            VALUES ('$name', '$price', '$desc', '$image', '$qty', '$catId')";
    if ($conn->query($sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Xatolik: " . $conn->error;
    }
}

$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Mahsulot qo‘shish</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>🛍️ Mahsulot qo‘shish</h2>
    <a href="category_create.php" class="btn btn-success">+ Kategoriya qo‘shish</a>
  </div>

  <form method="post" enctype="multipart/form-data" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label class="form-label">Nomi</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Narxi</label>
      <input type="number" step="0.01" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Tafsiloti</label>
      <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Miqdori</label>
      <input type="number" name="quantity" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Kategoriya</label>
      <select name="category_id" class="form-select" required>
        <option value="">-- Tanlang --</option>
        <?php while($cat = $categories->fetch_assoc()): ?>
          <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Rasm</label>
      <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Saqlash</button>
    <a href="index.php" class="btn btn-secondary ms-2">Ortga</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
