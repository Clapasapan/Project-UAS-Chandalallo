<?php
include '../includes/auth.php';
include '../includes/db.php';

// --- Ambil data kategori untuk dropdown
$kategori = $conn->query("SELECT * FROM kategori");

// --- Fungsi bersihkan nama file (tanpa ekstensi)
function bersihkan_nama_file($nama) {
    // hapus ekstensi
    $base = pathinfo($nama, PATHINFO_FILENAME);
    // ganti spasi & karakter aneh
    $base = preg_replace('/[^A-Za-z0-9-_]/', '_', $base);
    // batasi panjang (opsional)
    return substr($base, 0, 50);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama        = $_POST['nama_produk'];
    $deskripsi   = $_POST['deskripsi'];
    $harga       = (float) $_POST['harga'];
    $kondisi     = $_POST['kondisi'];
    $kategori_id = (int) $_POST['kategori_id'];

    // -------------------------------------------------
    // Tentukan folder upload absolut
    // __DIR__ = /.../cla-preloved/admin_produk
    // dirname(__DIR__) = /.../cla-preloved
    // -------------------------------------------------
    $uploadDir = dirname(__DIR__) . '/uploads/';

    // Pastikan ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // dev only
    }

    // Pastikan writeable
    if (!is_writable($uploadDir)) {
        @chmod($uploadDir, 0777); // coba perbaiki (dev)
        if (!is_writable($uploadDir)) {
            die("Folder uploads tidak bisa ditulis: $uploadDir");
        }
    }

    $gambar = ''; // default jika tidak ada upload

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $origName = $_FILES['gambar']['name'];
        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

        // Validasi ekstensi
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array($ext, $allowed)) {
            die("Ekstensi file tidak diperbolehkan: $ext");
        }

        // Batasi ukuran 2MB
        if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
            die("Ukuran file > 2MB, silakan kompres.");
        }

        // Buat nama file baru
        $base = bersihkan_nama_file($origName);
        $gambar = $base . '_' . time() . '.' . $ext;

        // Pindahkan
        $target = $uploadDir . $gambar;
        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            die("Gagal memindahkan file upload ke: $target");
        }
    } else {
        // Jika field file wajib → hentikan
        die("Harus memilih file gambar.");
    }

    // -------------------------------------------------
    // Simpan ke database (prepared)
    // -------------------------------------------------
    $sql = "INSERT INTO produk (nama_produk, deskripsi, harga, kondisi, kategori_id, gambar)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql) or die("Prepare gagal: " . $conn->error);
    // format: s s d s i s
    $stmt->bind_param("ssdsis", $nama, $deskripsi, $harga, $kondisi, $kategori_id, $gambar);

    if (!$stmt->execute()) {
        die("Insert gagal: " . $stmt->error);
    }

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container" style="max-width:600px;">
    <h4 class="mb-3">Tambah Produk</h4>
    <form method="post" enctype="multipart/form-data" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" min="0" step="1000" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kondisi</label>
            <select name="kondisi" class="form-select" required>
                <option value="baru">Baru</option>
                <option value="bekas">Bekas</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="kategori_id" class="form-select" required>
                <?php while ($k = $kategori->fetch_assoc()): ?>
                    <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Gambar (max 2MB)</label>
            <input type="file" name="gambar" class="form-control" accept="image/*" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</body>
</html>