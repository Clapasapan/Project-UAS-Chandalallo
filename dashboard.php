<?php
include 'includes/auth.php';
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Preloved Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand">Cla Preloved Store</span>
    <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
</nav>

<div class="container mt-4">
    <h3>Selamat Datang, <?= $_SESSION['nama'] ?>!</h3>
    <p class="text-muted">Ini adalah dashboard admin untuk mengelola toko barang pre-loved.</p>

    <div class="row">
        <div class="col-md-3">
            <a href="admin_user/index.php" class="btn btn-outline-primary w-100">Manajemen Admin</a>
        </div>
        <div class="col-md-3">
            <a href="admin_produk/index.php" class="btn btn-outline-success w-100">Manajemen Produk</a>
        </div>
        <div class="col-md-3">
            <a href="admin_laporan/index.php" class="btn btn-outline-info w-100">Laporan Transaksi</a>
        </div>
        <div class="col-md-3">
            <a href="admin_aktivitas/index.php" class="btn btn-outline-warning w-100">Log Aktivitas</a>
        </div>
    </div>
</div>
</body>
</html>