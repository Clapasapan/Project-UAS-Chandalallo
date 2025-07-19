<?php
include '../includes/auth.php';
include '../includes/db.php';

$id = $_GET['id'];
$kategori = $conn->query("SELECT * FROM kategori WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_kategori'];

    $conn->query("UPDATE kategori SET nama_kategori='$nama' WHERE id=$id");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h4>Edit Kategori</h4>
    <form method="post">
        <div class="mb-2">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" value="<?= $kategori['nama_kategori'] ?>" class="form-control" required>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
