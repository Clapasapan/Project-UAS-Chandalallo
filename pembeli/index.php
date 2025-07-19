<?php include '../includes/auth_pelanggan.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Halo, <?= $_SESSION['pelanggan_nama']; ?> 👋</h3>
    <p>Selamat datang di Cla Preloved!</p>
    <a href="produk.php" class="btn btn-primary">Lihat Produk</a>
    <a href="../logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>
