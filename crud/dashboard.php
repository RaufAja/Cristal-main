<?php
session_start();

// Proteksi Halaman: Jika pengguna belum login, tendang kembali ke halaman login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit;
}

include 'koneksi.php';

// 1. Ambil data spesifik dari pengguna yang sedang login
$username_sekarang = $_SESSION['username'];
$query_profil = "SELECT * FROM users WHERE username = '$username_sekarang'";
$result_profil = mysqli_query($conn, $query_profil);
$data_profil = mysqli_fetch_assoc($result_profil);

// 2. Ambil semua data pengguna dari database untuk ditampilkan di tabel
$query_semua = "SELECT id, username FROM users";
$result_semua = mysqli_query($conn, $query_semua);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Ekskul Cristal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4fbf7; /* Hijau sangat muda lembut */
            margin: 0;
            padding: 0;
            color: #333;
        }
        /* Style untuk Navigasi Atas */
        .navbar {
            background-color: #2e7d32; /* Hijau Tua */
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .navbar h1 {
            margin: 0;
            font-size: 20px;
        }
        .btn-logout {
            background-color: #d32f2f; /* Merah untuk keluar */
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn-logout:hover {
            background-color: #b71c1c;
        }
        /* Style untuk Konten Utama */
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }
        /* Kartu Selamat Datang / Profil */
        .welcome-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 5px solid #4caf50; /* Garis Hijau di samping */
            margin-bottom: 30px;
        }
        .welcome-card h2 {
            margin-top: 0;
            color: #2e7d32;
        }
        .welcome-card p {
            margin: 5px 0;
            color: #555;
        }
        /* Tabel Data */
        .table-container {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .table-container h3 {
            margin-top: 0;
            color: #2e7d32;
            margin-bottom: 20px;
            border-bottom: 2px solid #e8f5e9;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #4caf50; /* Hijau */
            color: white;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }
        tr {
            border-bottom: 1px solid #e0e0e0;
        }
        /* Efek baris belang-beling (zebra) */
        tr:nth-child(even) {
            background-color: #f9fbf9;
        }
        /* Efek saat baris disorot mouse */
        tr:hover {
            background-color: #f1f8f3;
        }
        .badge {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Bagian Navigasi -->
<div class="navbar">
    <h1>Panel Anggota - Ekskul Cristal</h1>
    <a href="logout.php" class="btn-logout">Keluar</a>
</div>

<div class="container">
    <!-- Bagian Info Profil Pengguna yang Login -->
    <div class="welcome-card">
        <h2>Selamat Datang, <?php echo htmlspecialchars($data_profil['username']); ?>! 👋</h2>
        <p>Anda berhasil login ke dalam sistem database Ekskul Cristal.</p>
        <p><strong>ID Pengguna Anda:</strong> <?php echo $data_profil['id']; ?></p>
    </div>

    <!-- Bagian Tabel Data Semua Pengguna -->
    <div class="table-container">
        <h3>Daftar Anggota / Pengguna Sistem</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID User</th>
                    <th>Username</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($result_semua)) { 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>#<?php echo $row['id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($row['username']); ?></strong></td>
                    <td>
                        <!-- Jika username di tabel sama dengan yang login, beri tanda khusus -->
                        <?php if($row['username'] == $username_sekarang) { ?>
                            <span class="badge" style="background-color: #2e7d32; color: white;">Anda Sedang Aktif</span>
                        <?php } else { ?>
                            <span class="badge">Terdaftar</span>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>