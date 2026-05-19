<?php
session_start();
// Hapus semua session
session_destroy();
// Alihkan kembali ke halaman login
header("location:login.php");
exit;
?>