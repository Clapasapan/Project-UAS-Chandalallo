<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();
    $user   = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['role_id']  = $user['role_id'];
        $_SESSION['nama']     = $user['nama'];

        // ✅ Tambahkan log aktivitas setelah login sukses
        $log_query = $conn->prepare("INSERT INTO log_aktivitas (user_id, aktivitas, waktu) VALUES (?, 'Login ke sistem', NOW())");
        $log_query->bind_param("i", $user['id']);
        $log_query->execute();

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Email atau password salah!";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Admin - Cla Preloved</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h4 class="mb-3 text-center">Login Admin Cla Preloved</h4>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">Login</button>
            </form>

            <!-- Tambahan Navigasi -->
            <div class="mt-3 text-center">
                <small>Login sebagai pembeli? <a href="login_pembeli.php">Klik di sini</a></small><br>
                <small>Belum punya akun pembeli? <a href="register_pembeli.php">Daftar di sini</a></small>
            </div>

        </div>
    </div>
</div>
</body>
</html>
