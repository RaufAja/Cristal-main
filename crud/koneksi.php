<?php
$host = "localhost";
$user = "2526_16";       // Default username XAMPP
$pass = "12345678";           // Default password XAMPP (kosong)
$db   = "2526_16db"; // Nama database yang dibuat di langkah 1

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>