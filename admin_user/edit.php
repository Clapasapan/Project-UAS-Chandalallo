<?php
include '../includes/auth.php';
include '../includes/db.php';

$id    = $_GET['id'];
$user  = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
$roles = $conn->query("SELECT * FROM roles");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama    = $_POST['nama'];
    $email   = $_POST['email'];
    $role_id = $_POST['role_id'];

    $conn->query("UPDATE users SET nama='$nama', email='$email', role_id=$role_id WHERE id=$id");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h4>Edit Pengguna</h4>
    <form method="post">
        <div class="mb-2">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= $user['nama'] ?>" required>
        </div>
        <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
        </div>
        <div class="mb-2">
            <label>Role</label>
            <select name="role_id" class="form-control" required>
                <?php while ($r = $roles->fetch_assoc()): ?>
                    <option value="<?= $r['id'] ?>" <?= $user['role_id'] == $r['id'] ? 'selected' : '' ?>>
                        <?= $r['nama_role'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>