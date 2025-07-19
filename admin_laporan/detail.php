<?php
include '../includes/auth.php';
include '../includes/db.php';

$id = $_GET['id'];
$transaksi = $conn->query("
    SELECT t.*, u.nama 
    FROM transaksi t 
    JOIN users u ON t.user_id = u.id 
    WHERE t.id = $id
")->fetch_assoc();

$detail = $conn->query("
    SELECT td.*, p.nama_produk 
    FROM transaksi_detail td 
    JOIN produk p ON td.produk_id = p.id 
    WHERE td.transaksi_id = $id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h4>Detail Transaksi</h4>

    <p><strong>Nama Pembeli:</strong> <?= $transaksi['nama'] ?></p>
    <p><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($transaksi['tanggal'])) ?></p>
    <p><strong>Status:</strong> <?= ucfirst($transaksi['status']) ?></p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($d = $detail->fetch_assoc()): ?>
            <tr>
                <td><?= $d['nama_produk'] ?></td>
                <td><?= $d['qty'] ?></td>
                <td><?= number_format($d['harga'], 0, ',', '.') ?></td>
                <td><?= number_format($d['harga'] * $d['qty'], 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary">Kembali</a>
</body>
</html>