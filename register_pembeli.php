<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Simpan ke tabel pelanggan
    $stmt = $conn->prepare("INSERT INTO pelanggan (nama, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $email, $password);
    $stmt->execute();

    header("Location: login_pembeli.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Pembeli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="col-md-5 mx-auto">
        <h4 class="text-center">Daftar Sebagai Pembeli</h4>
        <form method="post">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-success w-100">Daftar</button>
            <p class="text-center mt-3"><a href="login_pembeli.php">Sudah punya akun? Login di sini</a></p>
        </form>
    </div>
</div>
</body>
</html>
