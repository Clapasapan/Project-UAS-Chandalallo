<?php
include '../includes/db.php';
include '../includes/auth_pembeli.php';

if (!isset($_GET['id'])) {
    echo "ID transaksi tidak ditemukan!";
    exit;
}

$transaksi_id = $_GET['id'];

// Ambil data transaksi
$query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi 
    JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id 
    WHERE transaksi.id = '$transaksi_id'");
$transaksi = mysqli_fetch_assoc($query_transaksi);

// Ambil detail produk dalam transaksi
$query_detail = mysqli_query($conn, "SELECT transaksi_detail.*, produk.nama 
    FROM transaksi_detail 
    JOIN produk ON transaksi_detail.produk_id = produk.id 
    WHERE transaksi_id = '$transaksi_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Belanja</title>
    <style>
        body { font-family: Arial; }
        .struk { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #999; padding: 8px; text-align: left; }
        h2, h4 { text-align: center; }
    </style>
</head>
<body>
<div class="struk">
    <h2>CLA PRELOVED</h2>
    <h4>Struk Belanja</h4>

    <p><strong>Nama:</strong> <?= $transaksi['nama'] ?></p>
    <p><strong>Tanggal:</strong> <?= $transaksi['tanggal'] ?></p>
    <p><strong>Status:</strong> <?= $transaksi['status'] ?></p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $total = 0;
        while ($row = mysqli_fetch_assoc($query_detail)) {
            $subtotal = $row['qty'] * $row['harga'];
            $total += $subtotal;
            echo "<tr>
                <td>{$row['nama']}</td>
                <td>{$row['qty']}</td>
                <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
            </tr>";
        }
        ?>
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
        </tr>
        </tbody>
    </table>

    <p style="text-align: center; margin-top: 20px;">Terima kasih telah berbelanja di Cla Preloved ❤️</p>
</div>
</body>
</html>
