<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/auth.php';
include '../includes/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID produk tidak ditemukan");
}

$id = (int)$_GET['id'];

// Ambil data produk berdasarkan ID
$produk = $conn->query("SELECT * FROM produk WHERE id = $id")->fetch_assoc();
if (!$produk) {
    die("Produk tidak ditemukan");
}

// Ambil data kategori
$kategori = $conn->query("SELECT * FROM kategori");

// Update data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = (float)$_POST['harga'];
    $kondisi = $_POST['kondisi'];
    $kategori_id = (int)$_POST['kategori_id'];
    $gambar = $produk['gambar']; // default gambar lama

    // Jika upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
        $allowed_ext = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed_ext) && $_FILES['gambar']['size'] <= 2000000) {
            // Hapus gambar lama jika ada
            if (!empty($produk['gambar']) && file_exists("../uploads/" . $produk['gambar'])) {
                unlink("../uploads/" . $produk['gambar']);
            }
            $gambar = time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/" . $gambar);
        } else {
            die("Format gambar salah atau ukuran > 2MB");
        }
    }

    // Update ke database
    $stmt = $conn->prepare("UPDATE produk SET nama_produk=?, deskripsi=?, harga=?, kondisi=?, kategori_id=?, gambar=? WHERE id=?");
    $stmt->bind_param("ssdsssi", $nama, $deskripsi, $harga, $kondisi, $kategori_id, $gambar, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h4>Edit Produk</h4>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($produk['nama_produk']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required><?= htmlspecialchars($produk['deskripsi']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($produk['harga']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Kondisi</label>
            <select name="kondisi" class="form-control" required>
                <option value="baru" <?= $produk['kondisi']=='baru'?'selected':'' ?>>Baru</option>
                <option value="bekas" <?= $produk['kondisi']=='bekas'?'selected':'' ?>>Bekas</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori_id" class="form-control" required>
                <?php while ($k = $kategori->fetch_assoc()): ?>
                    <option value="<?= $k['id'] ?>" <?= $k['id']==$produk['kategori_id']?'selected':'' ?>>
                        <?= htmlspecialchars($k['nama_kategori']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Gambar Saat Ini:</label><br>
            <?php if (!empty($produk['gambar'])): ?>
                <img src="/CLA-PRELOVED/uploads/<?= htmlspecialchars($produk['gambar']) ?>" width="100" alt="Produk">
            <?php else: ?>
                <span class="text-muted">Tidak ada gambar</span>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Upload Gambar Baru (opsional)</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>