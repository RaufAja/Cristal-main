<?php
include 'koneksi.php';

// Membuat tabel otomatis jika ternyata belum ada
$buat_tabel = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $buat_tabel);

// Menyiapkan akun baru
$username = 'admin';
$password = md5('password123'); // Password otomatis dienkripsi

// Menghapus user lama jika kebetulan nyangkut, lalu memasukkan yang baru
mysqli_query($conn, "DELETE FROM users WHERE username='$username'");
$query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

if(mysqli_query($conn, $query)){
    echo "<h3>SUKSES! Akun berhasil dibuat di server.</h3>";
    echo "Silakan kembali ke halaman login dan gunakan:<br>";
    echo "Username: <b>admin</b> <br> Password: <b>password123</b>";
} else {
    echo "Gagal membuat user: " . mysqli_error($conn);
}
?>