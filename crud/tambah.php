<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit;
}

// Jika tombol simpan ditekan
if(isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi password baru

    // Masukkan ke database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Anggota baru berhasil ditambahkan!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Anggota - Ekskul Cristal</title>
    <style>
        body { font-family: sans-serif; background-color: #f4fbf7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 300px; border-top: 5px solid #2e7d32; }
        .form-box h2 { color: #2e7d32; margin-top: 0; text-align: center; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-submit { background-color: #2e7d32; color: white; width: 100%; padding: 10px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-kembali { display: block; text-align: center; margin-top: 15px; color: #555; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Tambah Anggota</h2>
        <form method="POST" action="">
            <label>Username</label>
            <input type="text" name="username" required>
            
            <label>Password</label>
            <input type="password" name="password" required>
            
            <button type="submit" name="simpan" class="btn-submit">Simpan Data</button>
            <a href="dashboard.php" class="btn-kembali">Kembali ke Dashboard</a>
        </form>
    </div>
</body>
</html>