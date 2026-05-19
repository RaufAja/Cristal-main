<?php
session_start();
include 'koneksi.php';

$error = '';

// Proses jika tombol login ditekan
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    // Mengenkripsi password inputan ke MD5 untuk dicocokkan dengan database
    $password = md5($_POST['password']); 

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Jika login berhasil
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "login";
        // Arahkan ke halaman dashboard (kamu bisa membuat file dashboard.php nanti)
        echo "<script>alert('Selamat datang di portal Ekskul Cristal!'); window.location='dashboard.php';</script>";
    } else {
        // Jika login gagal
        $error = 'Username atau Password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ekskul Cristal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e8f5e9; /* Hijau sangat muda */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            width: 320px;
            text-align: center;
            border-top: 6px solid #2e7d32; /* Hijau tua */
        }
        .login-box h2 {
            margin-top: 0;
            color: #2e7d32;
            margin-bottom: 25px;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group label {
            display: block;
            color: #4caf50; /* Hijau menengah */
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #a5d6a7;
            border-radius: 6px;
            box-sizing: border-box; /* Agar padding tidak merusak lebar */
            outline: none;
        }
        .input-group input:focus {
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }
        .btn-login {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-login:hover {
            background-color: #388e3c;
        }
        .error-msg {
            color: #d32f2f;
            background-color: #ffebee;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Ekskul Cristal</h2>
    
    <?php if ($error != ''): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required>
        </div>
        
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>
        
        <button type="submit" name="login" class="btn-login">Masuk</button>
    </form>
</div>

</body>
</html>