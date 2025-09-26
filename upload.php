<?php require_once __DIR__ . '/db.php'; ?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>อัปโหลดผลงาน</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h1 class="mb-4">เพิ่มผลงานใหม่</h1>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $title = $_POST['title'] ?? '';
      $desc  = $_POST['description'] ?? '';
      $file  = $_FILES['image'] ?? null;

      if ($title && $desc && $file && $file['error'] === UPLOAD_ERR_OK) {
          $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
          $safeName = uniqid('art_', true) . '.' . $ext;
          $target = __DIR__ . '/uploads/' . $safeName;

          if (move_uploaded_file($file['tmp_name'], $target)) {
              $url = 'uploads/' . $safeName;
              $stmt = $mysqli->prepare("INSERT INTO artworks (title, description, image_url) VALUES (?,?,?)");
              $stmt->bind_param("sss", $title, $desc, $url);
              $stmt->execute();
              echo '<div class="alert alert-success">✔️ เพิ่มผลงานเรียบร้อยแล้ว</div>';
          } else {
              echo '<div class="alert alert-danger">❌ ไม่สามารถบันทึกรูปได้</div>';
          }
      } else {
          echo '<div class="alert alert-warning">กรุณากรอกข้อมูลและเลือกรูปภาพ</div>';
      }
  }
  ?>

  <form method="post" enctype="multipart/form-data" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label class="form-label">ชื่อผลงาน</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">คำอธิบาย</label>
      <textarea name="description" class="form-control" rows="3" required></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">เลือกรูปภาพ</label>
      <input type="file" name="image" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-primary">อัปโหลด</button>
    <a href="index.php" class="btn btn-secondary">กลับหน้าแสดงผลงาน</a>
  </form>
</div>
</body>
</html>
