<?php
session_start();

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

$auth  = new AuthController($koneksi);
$error = null;

if(isset($_POST['login'])){

    $result = $auth->login($_POST['username'], $_POST['password']);

    if($result['success']){
        header("Location: " . $result['redirect']);
        exit;
    }

    $error = $result['error'];

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login — DeadlineHub</title>

<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="theme-auth">

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
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <div class="password-wrapper">

                        <input
                            class="form-input"
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Masukkan password..."
                            required
                        >

                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)" aria-label="Tampilkan password">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                    </div>

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

<script>

function togglePassword(fieldId, btn){

    const input = document.getElementById(fieldId);
    const icon = btn.querySelector('i');

    if(input.type === 'password'){
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }else{
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }

}

</script>

</body>
</html>