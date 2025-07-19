<?php
include '../includes/auth.php';
include '../includes/db.php';

$roles = $conn->query("SELECT * FROM roles");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id  = $_POST['role_id'];

    $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nama, $email, $password, $role_id);
    $stmt->execute();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h4>Tambah Pengguna</h4>
    <form method="post">
        <div class="mb-2">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Role</label>
            <select name="role_id" class="form-control" required>
                <?php while ($r = $roles->fetch_assoc()): ?>
                    <option value="<?= $r['id'] ?>"><?= $r['nama_role'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>