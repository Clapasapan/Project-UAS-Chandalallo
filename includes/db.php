<?php
$host = '127.0.0.1';
$user = 'root';
$pass = ''; // sesuaikan jika pakai password
$db   = 'preloved_store';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>