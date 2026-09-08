<?php
session_start();
include '../config/koneksi.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $username_esc = mysqli_real_escape_string($koneksi, $username);
    $password_esc = mysqli_real_escape_string($koneksi, $password);

    $query = mysqli_query($koneksi, "
        SELECT * FROM users
        WHERE username='$username_esc'
        AND password='$password_esc'
    ");

    $cek = mysqli_num_rows($query);

    if($cek > 0){

        $data = mysqli_fetch_assoc($query);

        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['id'] = $data['id'];

        // REDIRECT BERDASARKAN ROLE

        if($data['role'] == "admin"){

            header("Location: ../admin/index.php");

        }elseif($data['role'] == "guru"){

            header("Location: ../Guru/index.php");

        }elseif($data['role'] == "siswa"){

            header("Location: ../Siswa/index.php");

        }

        exit;

    }else{

        $error = "Username atau password salah!";

    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login — DeadlineHub</title>

<link rel="stylesheet" href="../assets/css/auth.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<div class="auth-shell">

    <div class="auth-brand">

        <div class="auth-brand-top">

            <div class="auth-logo">
                <div class="auth-logo-mark">DH</div>
                <div class="auth-logo-name">DeadlineHub</div>
            </div>

            <span class="auth-tag">Selamat datang kembali</span>

            <h1 class="auth-brand-title">
                Kelola tugas dan<br>deadline kelasmu.
            </h1>

            <p class="auth-brand-sub">
                Masuk untuk melihat tugas, mengumpulkan jawaban, dan memantau progres belajar dalam satu tempat.
            </p>

        </div>

        <div class="auth-brand-bottom">

            <div class="auth-feature-list">

                <div class="auth-feature">
                    <i class="fa-solid fa-clock"></i>
                    Notifikasi deadline tugas
                </div>

                <div class="auth-feature">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    Upload jawaban langsung online
                </div>

                <div class="auth-feature">
                    <i class="fa-solid fa-chart-line"></i>
                    Pantau progres dan nilai
                </div>

            </div>

        </div>

    </div>

    <div class="auth-panel">

        <div class="auth-box">

            <div class="eyebrow">Masuk Akun</div>
            <h1>Selamat Datang 👋</h1>
            <p class="lead">Login ke DeadlineHub.</p>

            <?php if(isset($error)) { ?>

                <div class="auth-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= htmlspecialchars($error) ?>
                </div>

            <?php } ?>

            <form method="POST">

                <div class="form-group">

                    <label>Username</label>

                    <input
                        class="form-input"
                        type="text"
                        name="username"
                        placeholder="Masukkan username..."
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input
                        class="form-input"
                        type="password"
                        name="password"
                        placeholder="Masukkan password..."
                        required
                    >

                </div>

                <button type="submit" class="submit-btn" name="login">
                    Login
                </button>

            </form>

            <div class="auth-switch">
                Belum punya akun?
                <a href="register.php">Register</a>
            </div>

        </div>

    </div>

</div>

</body>
</html>