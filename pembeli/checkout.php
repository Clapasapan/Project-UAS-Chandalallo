<?php
session_start();
include '../includes/auth_pembeli.php';
include '../includes/db.php';

if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}

$produk_id = $_GET['id'];
$pelanggan_id = $_SESSION['pelanggan_id'];

// Ambil data produk
$query = $conn->prepare("SELECT * FROM produk WHERE id = ?");
$query->bind_param("i", $produk_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    die("Produk tidak ditemukan.");
}
$produk = $result->fetch_assoc();

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $qty = intval($_POST['qty']);
    $metode = $_POST['metode'];

    if ($qty <= 0 || empty($metode)) {
        echo "<script>alert('Jumlah dan metode pembayaran wajib diisi');</script>";
    } else {
        $total = $qty * $produk['harga'];
        $tanggal = date("Y-m-d H:i:s");
        $status = 'berhasil';

        // Simpan transaksi
        $stmt = $conn->prepare("INSERT INTO transaksi (user_id, total, tanggal, status, metode_pembayaran) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idsss", $pelanggan_id, $total, $tanggal, $status, $metode);
        $stmt->execute();
        $transaksi_id = $stmt->insert_id;

        // Simpan detail transaksi
        $stmt_detail = $conn->prepare("INSERT INTO transaksi_detail (transaksi_id, produk_id, qty, harga) VALUES (?, ?, ?, ?)");
        $stmt_detail->bind_param("iiid", $transaksi_id, $produk_id, $qty, $produk['harga']);
        $stmt_detail->execute();

        // Redirect ke halaman berhasil
        header("Location: berhasil.php?id=$transaksi_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Cla Preloved</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
        }
        .produk-img {
    width: 250px;
    height: 250px;
    object-fit: cover;
    border-radius: 10px;
}

    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Checkout Produk</h4>
        </div>
        <div class="card-body">
            <!-- Gambar Produk -->
            <div class="text-center mb-4">
                <img src="../uploads/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= htmlspecialchars($produk['nama_produk']) ?>" class="produk-img">
            </div>

            <form method="POST">
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Nama Produk</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= htmlspecialchars($produk['nama_produk']) ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Harga</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="Rp<?= number_format($produk['harga']) ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Jumlah</label>
                    <div class="col-sm-8">
                        <input type="number" name="qty" class="form-control" min="1" value="1" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                    <div class="col-sm-8">
                        <select name="metode" class="form-select" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="transfer_bank">Transfer Bank</option>
                            <option value="dana">DANA</option>
                            <option value="ovo">OVO</option>
                            <option value="gopay">GoPay</option>
                            <option value="shopeepay">ShopeePay</option>
                        </select>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success me-2">Bayar Sekarang</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
