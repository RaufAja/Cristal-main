<?php
session_start();
include 'koneksi.php';

// Pastikan hanya yang sudah login yang bisa menghapus
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit;
}

// Tangkap ID dari URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data berdasarkan ID
    mysqli_query($conn, "DELETE FROM users WHERE id = '$id'");
}

// Alihkan kembali ke dashboard
header("location:dashboard.php");
exit;
?>