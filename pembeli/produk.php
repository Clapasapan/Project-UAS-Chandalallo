<?php
include '../includes/db.php';
session_start();
include '../includes/auth_pelanggan.php';

// Ambil semua produk
$result = $conn->query("SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk - Cla Preloved</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            object-fit: cover;
            height: 180px;
        }
        .truncate-text {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <h3 class="mb-4">Produk Cla Preloved</h3>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="../uploads/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($row['nama_produk']) ?></h5>
                        <p class="card-text text-muted truncate-text"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
                        <p class="card-text fw-bold text-success mt-auto">Rp<?= number_format($row['harga']) ?></p>
                        <a href="beli.php?id=<?= $row['id'] ?>" class="btn btn-primary mt-2">Beli Sekarang</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
