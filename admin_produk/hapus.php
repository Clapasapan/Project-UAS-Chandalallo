<?php
include '../includes/auth.php';
include '../includes/db.php';

$id = (int)$_GET['id'];
$produk = $conn->query("SELECT * FROM produk WHERE id = $id")->fetch_assoc();

if ($produk) {
    if (!empty($produk['gambar']) && file_exists("../uploads/" . $produk['gambar'])) {
        unlink("../uploads/" . $produk['gambar']);
    }
    $conn->query("DELETE FROM produk WHERE id = $id");
}

header("Location: index.php");
exit;