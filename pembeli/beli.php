<?php
session_start();
include '../includes/auth_pembeli.php'; // Harus set $_SESSION['pelanggan_id']
include '../includes/db.php';

if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}

$produk_id = (int) $_GET['id'];

// Pastikan pelanggan login
if (!isset($_SESSION['pelanggan_id'])) {
    die("Anda belum login.");
}
$user_id = $_SESSION['pelanggan_id']; // Sesuai dengan kolom user_id di tabel transaksi

// Ambil data produk
$stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->bind_param("i", $produk_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Produk tidak ditemukan.");
}

$produk = $result->fetch_assoc();

// Handle Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qty = isset($_POST['qty']) ? (int) $_POST['qty'] : 0;
    $metode = isset($_POST['metode']) ? trim($_POST['metode']) : '';

    if ($qty <= 0 || $metode == '') {
        echo "<script>alert('Jumlah dan metode pembayaran wajib diisi.'); window.history.back();</script>";
        exit;
    }

    $total = $qty * $produk['harga'];
    $tanggal = date("Y-m-d H:i:s");
    $status = 'berhasil';

    // Simpan transaksi
    $stmt = $conn->prepare("INSERT INTO transaksi (user_id, total, tanggal, status, metode_pembayaran) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("idsss", $user_id, $total, $tanggal, $status, $metode);
    $stmt->execute();
    $transaksi_id = $stmt->insert_id;

    // Simpan detail transaksi
    $stmt2 = $conn->prepare("INSERT INTO transaksi_detail (transaksi_id, produk_id, qty, harga) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("iiid", $transaksi_id, $produk_id, $qty, $produk['harga']);
    $stmt2->execute();

    // Redirect
    header("Location: berhasil.php?id=$transaksi_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .produk-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4>Checkout Produk</h4>
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                <img src="../uploads/<?= htmlspecialchars($produk['gambar']) ?>" class="produk-img" alt="<?= htmlspecialchars($produk['nama_produk']) ?>">
            </div>
            <form method="POST">
                <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($produk['nama_produk']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="text" class="form-control" value="Rp<?= number_format($produk['harga']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Jumlah</label>
                    <input type="number" name="qty" class="form-control" min="1" required>
                </div>
                <div class="mb-4">
                    <label>Metode Pembayaran</label>
                    <select name="metode" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="transfer_bank">Transfer Bank</option>
                        <option value="dana">DANA</option>
                        <option value="ovo">OVO</option>
                        <option value="gopay">GoPay</option>
                        <option value="shopeepay">ShopeePay</option>
                    </select>
                </div>
                <div class="text-center">
                    <button class="btn btn-success" type="submit">Bayar Sekarang</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
