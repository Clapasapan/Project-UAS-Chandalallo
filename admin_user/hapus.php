<?php
include '../includes/auth.php';
include '../includes/db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id = $id");

header("Location: index.php");