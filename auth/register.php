<?php

include '../config/koneksi.php';

$error = null;

if(isset($_POST['register'])){

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    $role = "siswa";

    if($username === '' || $password === ''){

        $error = "Username dan password wajib diisi!";

    }elseif($password !== $confirm){

        $error = "Konfirmasi password tidak cocok!";

    }else{

        $username_esc = mysqli_real_escape_string($koneksi, $username);
        $password_esc = mysqli_real_escape_string($koneksi, $password);

        $cek = mysqli_query($koneksi, "
            SELECT id FROM users WHERE username='$username_esc'
        ");

        if(mysqli_num_rows($cek) > 0){

            $error = "Username sudah dipakai, coba yang lain!";

        }else{

            mysqli_query($koneksi, "
                INSERT INTO users(username,password,role)
                VALUES('$username_esc','$password_esc','$role')
            ");

            header("Location: login.php");
            exit;

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register — DeadlineHub</title>

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

            <span class="auth-tag">Bergabung sekarang</span>

            <h1 class="auth-brand-title">
                Satu akun untuk<br>pantau semua tugas kelas.
            </h1>

            <p class="auth-brand-sub">
                Daftar sebagai siswa untuk mulai melacak deadline, mengumpulkan tugas, dan melihat nilai secara real-time.
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

            <div class="eyebrow">Daftar Akun</div>
            <h1>Buat Akun ✨</h1>
            <p class="lead">Daftar akun DeadlineHub sebagai siswa.</p>

            <?php if($error){ ?>

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
                        value="<?= isset($username) ? htmlspecialchars($username) : '' ?>"
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

                <div class="form-group">

                    <label>Konfirmasi Password</label>

                    <input
                        class="form-input"
                        type="password"
                        name="confirm_password"
                        placeholder="Ulangi password..."
                        required
                    >

                </div>

                <button type="submit" class="submit-btn" name="register">
                    Register
                </button>

            </form>

            <div class="auth-switch">
                Sudah punya akun?
                <a href="login.php">Login</a>
            </div>

        </div>

    </div>

</div>

</body>
</html>