<?php
session_start();
include 'koneksi.php';

// 1. Proteksi Halaman: Cek apakah pengguna sudah login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit;
}

$username_sekarang = $_SESSION['username'];

// 2. Ambil data user yang sedang aktif untuk mendapatkan ID Pengguna
$query_user = "SELECT id FROM users WHERE username = '$username_sekarang'";
$result_user = mysqli_query($conn, $query_user);
$data_user = mysqli_fetch_assoc($result_user);
$id_pengguna_anda = $data_user['id'] ?? 1;

// 3. Ambil semua data anggota dari database untuk ditampilkan di tabel
$query_semua = "SELECT * FROM users ORDER BY id ASC";
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
            background-color: #f4fbf7; /* Latar belakang hijau sangat muda polos */
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Top Navbar */
        .navbar {
            background-color: #2e7d32; /* Hijau tua khas Cristal */
            color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar .nav-title {
            font-size: 20px;
            font-weight: bold;
        }
        .btn-logout {
            background-color: #d32f2f;
            color: white;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn-logout:hover {
            background-color: #b71c1c;
        }

        /* Container Utama */
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Struktur Card (Kotak Putih) */
        .card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        /* Card Selamat Datang (Dengan Garis Hijau di Kiri) */
        .welcome-card {
            border-left: 5px solid #2e7d32;
        }
        .welcome-card h2 {
            color: #2e7d32;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .welcome-card p {
            margin: 5px 0;
            color: #555;
        }

        /* Card Tabel */
        .table-card h3 {
            color: #2e7d32;
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #f4fbf7;
            padding-bottom: 10px;
        }

        /* Tombol Tambah Data */
        .btn-tambah {
            background-color: #2e7d32;
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
            font-size: 14px;
            transition: 0.3s;
            box-shadow: 0 2px 4px rgba(46, 125, 50, 0.2);
        }
        .btn-tambah:hover {
            background-color: #1b5e20;
        }

        /* Desain Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        th {
            background-color: #4caf50; /* Hijau terang papan tabel */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        td {
            font-size: 15px;
        }
        tr:hover td {
            background-color: #f9fbf9;
        }

        /* Badge Status */
        .badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
        .badge-active {
            background-color: #2e7d32;
            color: white;
        }
        .badge-registered {
            background-color: #e0e0e0;
            color: #666;
        }

        /* Tombol Aksi Hapus */
        .btn-hapus {
            background-color: #e53935;
            color: white;
            text-decoration: none;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
        }
        .btn-hapus:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="nav-title">Panel Anggota - Ekskul Cristal</div>
        <a href="logout.php" class="btn-logout">Keluar</a>
    </div>

    <div class="container">
        
        <div class="card welcome-card">
            <h2>Selamat Datang, <?php echo htmlspecialchars($username_sekarang); ?>! 👋</h2>
            <p>Anda berhasil login ke dalam sistem database Ekskul Cristal.</p>
            <p><strong>ID Pengguna Anda:</strong> <?php echo $id_pengguna_anda; ?></p>
        </div>

        <div class="card table-card">
            <h3>Daftar Anggota / Pengguna Sistem</h3>
            
            <a href="tambah.php" class="btn-tambah">+ Tambah Anggota Baru</a>

            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">NO</th>
                        <th style="width: 15%;">ID USER</th>
                        <th style="width: 35%;">USERNAME</th>
                        <th style="width: 22%;">STATUS</th>
                        <th style="width: 20%;">AKSI</th>
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
                            <?php if($row['username'] == $username_sekarang) { ?>
                                <span class="badge badge-active">Anda Sedang Aktif</span>
                            <?php } else { ?>
                                <span class="badge badge-registered">Terdaftar</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($row['username'] != $username_sekarang) { ?>
                                <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus anggota ini?');">Hapus</a>
                            <?php } else { ?>
                                <span style="font-size: 13px; color: #999; font-style: italic;">(Akun Anda)</span>
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