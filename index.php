<?php require_once __DIR__ . '/db.php'; ?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>The 69th National Exhibition of Art – Gallery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{ background:#fff7f0; }
    .navbar{ background:#6f42c1; }
    .navbar-brand, .navbar-text{ color:#fff !important; }
    .card{ border:none; box-shadow:0 8px 24px rgba(0,0,0,.08); transition:.2s; }
    .card:hover{ transform:translateY(-3px); box-shadow:0 12px 30px rgba(0,0,0,.12); }
    .card img{ height:200px; object-fit:cover; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/art/">Art Exhibition Gallery</a>
    <span class="navbar-text ms-auto">The 69th National Exhibition of Art</span>
  </div>
</nav>

<main class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">ผลงานที่ชื่นชอบ</h1>
    <a href="upload.php" class="btn btn-primary">➕ เพิ่มผลงาน</a>
  </div>

  <div class="row g-4">
    <?php
      $sql = "SELECT id, title, description, image_url FROM artworks ORDER BY id DESC";
      if ($res = $mysqli->query($sql)) {
        if ($res->num_rows === 0) {
          echo '<div class="col-12"><div class="alert alert-warning">ยังไม่มีข้อมูลผลงาน กรุณาเพิ่มผ่านหน้า <a href="upload.php">อัปโหลด</a></div></div>';
        }
        while ($row = $res->fetch_assoc()) {
          $title = htmlspecialchars($row['title']);
          $desc  = nl2br(htmlspecialchars($row['description']));
          $img   = htmlspecialchars($row['image_url']);
          // ถ้า path ไม่ใช่ URL เต็ม ให้ prepend ./art/
          if (!preg_match('/^https?:\\/\\//', $img)) {
            $img = $img;
          }
          echo '<div class="col-12 col-md-6 col-lg-4">';
          echo '  <div class="card h-100">';
          echo '    <img src="'.$img.'" class="card-img-top" alt="'.$title.'">';
          echo '    <div class="card-body">';
          echo '      <h5 class="card-title">'.$title.'</h5>';
          echo '      <p class="card-text">'.$desc.'</p>';
          echo '    </div>';
          echo '  </div>';
          echo '</div>';
        }
        $res->free();
      } else {
        echo '<div class="col-12"><div class="alert alert-danger">Query error: '.htmlspecialchars($mysqli->error).'</div></div>';
      }
    ?>
  </div>
</main>

<footer class="container pb-5">
  <hr>
  <p class="small">โครงการสาธิตเพื่อการศึกษา • AWS EC2 (Windows = Web, Ubuntu = DB)</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
