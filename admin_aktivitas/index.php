<?php
include '../includes/auth.php';
include '../includes/db.php';

$log = $conn->query("
    SELECT log_aktivitas.*, users.nama 
    FROM log_aktivitas 
    JOIN users ON log_aktivitas.user_id = users.id 
    ORDER BY waktu DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log Aktivitas Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h4>Monitoring Aktivitas</h4>
    <table class="table table-bordered table-hover mt-3">
        <thead>
            <tr>
                <th>Nama Pengguna</th>
                <th>Aktivitas</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($l = $log->fetch_assoc()): ?>
            <tr>
                <td><?= $l['nama'] ?></td>
                <td><?= $l['aktivitas'] ?></td>
                <td><?= date('d-m-Y H:i:s', strtotime($l['waktu'])) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>