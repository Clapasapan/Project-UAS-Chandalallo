<?php
include '../includes/auth.php';
include '../includes/db.php';

$transaksi = $conn->query("
    SELECT t.*, u.nama 
    FROM transaksi t 
    JOIN users u ON t.user_id = u.id 
    ORDER BY t.tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h4>Laporan Transaksi</h4>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Nama Pembeli</th>
                <th>Tanggal</th>
                <th>Total (Rp)</th>
                <th>Status</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($t = $transaksi->fetch_assoc()): ?>
            <tr>
                <td><?= $t['nama'] ?></td>
                <td><?= date('d-m-Y H:i', strtotime($t['tanggal'])) ?></td>
                <td><?= number_format($t['total'], 0, ',', '.') ?></td>
                <td>
                    <span class="badge bg-<?= $t['status'] == 'selesai' ? 'success' : 'warning' ?>">
                        <?= ucfirst($t['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="detail.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-info">Lihat</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>