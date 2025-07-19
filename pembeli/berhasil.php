<?php
session_start();
include '../includes/auth_pelanggan.php';
include '../includes/db.php';

// Pastikan ID transaksi ada di URL
if (!isset($_GET['id'])) {
    die("ID transaksi tidak ditemukan.");
}

$transaksi_id = intval($_GET['id']);
$pelanggan_id = $_SESSION['pelanggan_id'];

// Ambil data transaksi
$stmt = $conn->prepare("SELECT * FROM transaksi WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $transaksi_id, $pelanggan_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Transaksi tidak ditemukan atau bukan milik Anda.");
}

$transaksi = $result->fetch_assoc();

// Ambil detail transaksi
$detail_stmt = $conn->prepare("
    SELECT td.*, p.nama_produk 
    FROM transaksi_detail td 
    JOIN produk p ON td.produk_id = p.id 
    WHERE td.transaksi_id = ?
");
$detail_stmt->bind_param("i", $transaksi_id);
$detail_stmt->execute();
$detail_result = $detail_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Belanja - Cla Preloved</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Struk Belanja</h4>
        </div>
        <div class="card-body">
            <p><strong>ID Transaksi:</strong> <?= $transaksi['id']; ?></p>
            <p><strong>Tanggal:</strong> <?= $transaksi['tanggal']; ?></p>
            <p><strong>Status:</strong> <?= ucfirst($transaksi['status']); ?></p>
            <p><strong>Metode Pembayaran:</strong> <?= strtoupper($transaksi['metode_pembayaran']); ?></p>

            <hr>
            <h5>Detail Produk:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    while ($row = $detail_result->fetch_assoc()): 
                        $subtotal = $row['harga'] * $row['qty'];
                        $grand_total += $subtotal;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                            <td>Rp<?= number_format($row['harga']); ?></td>
                            <td><?= $row['qty']; ?></td>
                            <td>Rp<?= number_format($subtotal); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h5 class="text-end">Total: Rp<?= number_format($grand_total); ?></h5>
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
                <button onclick="window.print()" class="btn btn-secondary">Cetak Struk</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
