<?php
session_start();
include 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Catat aktivitas logout
    $log = $conn->prepare("INSERT INTO log_aktivitas (user_id, aktivitas, waktu) VALUES (?, 'Logout dari sistem', NOW())");
    $log->bind_param("i", $user_id);
    $log->execute();
}

session_destroy();
header("Location: login.php");
exit;
?>
