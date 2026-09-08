<?php
session_start();
include '../config/koneksi.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "
        SELECT * FROM users 
        WHERE username='$username'
        AND password='$password'
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

<title>Login</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    background: #ddd2c3;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-box{
    width: 420px;
    background: #e9dfd2;
    padding: 45px;
    border-radius: 35px;

    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.login-box h1{
    font-size: 42px;
    color: #4d3828;
    margin-bottom: 10px;
}

.login-box p{
    color: #7a6758;
    margin-bottom: 35px;
}

.input-group{
    margin-bottom: 22px;
}

.input-group label{
    display: block;
    margin-bottom: 10px;
    color: #5c4635;
    font-weight: 600;
}

.input-group input{
    width: 100%;
    padding: 18px 20px;

    border: none;
    outline: none;

    border-radius: 18px;

    background: #f8f3ed;

    font-size: 15px;
}

button{
    width: 100%;
    padding: 18px;

    border: none;
    border-radius: 18px;

    background: #a67c5b;
    color: white;

    font-size: 16px;
    font-weight: 600;

    cursor: pointer;

    transition: 0.3s;
}

button:hover{
    background: #8f684a;
}

.error{
    background: #ffd7d7;
    color: #b40000;

    padding: 14px;
    border-radius: 14px;

    margin-bottom: 20px;
    font-size: 14px;
}

.register{
    text-align: center;
    margin-top: 20px;
}

.register a{
    color: #8f684a;
    text-decoration: none;
    font-weight: 600;
}

</style>

</head>

<body>

<div class="login-box">

    <h1>Welcome 👋</h1>
    <p>Login ke DeadlineHub</p>

    <?php if(isset($error)) { ?>

        <div class="error">
            <?php echo $error; ?>
        </div>

    <?php } ?>

    <form method="POST">

        <div class="input-group">

            <label>Username</label>

            <input 
                type="text" 
                name="username"
                placeholder="Masukkan username..."
                required
            >

        </div>

        <div class="input-group">

            <label>Password</label>

            <input 
                type="password" 
                name="password"
                placeholder="Masukkan password..."
                required
            >

        </div>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <div class="register">
        Belum punya akun?
        <a href="register.php">Register</a>
    </div>

</div>

</body>
</html>