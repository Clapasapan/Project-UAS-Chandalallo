<?php
include '../includes/auth.php';
include '../includes/db.php';

$kategori = $conn->query("SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h4>Daftar Kategori</h4>
    <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Kategori</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($k = $kategori->fetch_assoc()): ?>
            <tr>
                <td><?= $k['nama_kategori'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $k['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus.php?id=<?= $k['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>