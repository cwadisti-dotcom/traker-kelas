<?php

include '../config/koneksi.php';

if(isset($_POST['register'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $role = "siswa";

    mysqli_query($conn, "
        INSERT INTO users(username,password,role)
        VALUES('$username','$password','$role')
    ");

    header("Location: login.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register</title>

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

.register-box{
    width: 420px;

    background: #e9dfd2;

    padding: 45px;

    border-radius: 35px;

    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.register-box h1{
    font-size: 42px;

    color: #4d3828;

    margin-bottom: 10px;
}

.register-box p{
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

.login{
    text-align: center;

    margin-top: 20px;
}

.login a{
    color: #8f684a;

    text-decoration: none;

    font-weight: 600;
}

</style>

</head>

<body>

<div class="register-box">

    <h1>Create Account ✨</h1>
    <p>Daftar akun DeadlineHub</p>

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

        <button type="submit" name="register">
            Register
        </button>

    </form>

    <div class="login">
        Sudah punya akun?
        <a href="login.php">Login</a>
    </div>

</div>

</body>
</html>