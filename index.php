<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Mahsulotlar ro‘yxati</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">📦 Mahsulotlar ro‘yxati</h2>
    <a href="create.php" class="btn btn-success">+ Mahsulot qo‘shish</a>
  </div>

  <div class="card shadow-sm p-3">
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Rasm</th>
            <th>Nomi</th>
            <th>Narxi</th>
            <th>Tafsiloti</th>
            <th>Miqdori</th>
            <th>Kategoriya</th>
            <th>Amallar</th>
          </tr>
        </thead>
        <tbody>
        <?php
        // JOIN orqali kategoriyani olish
        $res = $conn->query("
            SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
        ");

        while($row = $res->fetch_assoc()):
        ?>
          <tr>
            <td>
              <?php if ($row['image']): ?>
                <img src="uploads/<?= $row['image'] ?>" width="80" class="rounded">
              <?php else: ?>
                <span class="text-muted">Yo‘q</span>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['price']) ?>so'm</td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['quantity']) ?> kg</td>
            <td><?= htmlspecialchars($row['category_name'] ?? '—') ?></td>
            <td>
              <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary me-1">✏️</a>
              <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Ishonchingiz komilmi?')" class="btn btn-sm btn-outline-danger">🗑️</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
