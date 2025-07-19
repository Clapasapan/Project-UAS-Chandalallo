<?php
include '../includes/auth.php';
include '../includes/db.php';

$users = $conn->query("SELECT users.*, roles.nama_role FROM users 
                       LEFT JOIN roles ON users.role_id = roles.id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h4>Daftar Admin</h4>
    <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah User</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($u = $users->fetch_assoc()) : ?>
            <tr>
                <td><?= $u['nama'] ?></td>
                <td><?= $u['email'] ?></td>
                <td><?= $u['nama_role'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus.php?id=<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>