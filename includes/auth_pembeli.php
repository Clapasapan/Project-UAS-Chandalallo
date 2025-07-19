<?php
session_start();
if (!isset($_SESSION['pelanggan_id'])) {
    header("Location: ../login_pelanggan.php");
    exit;
}
?>
