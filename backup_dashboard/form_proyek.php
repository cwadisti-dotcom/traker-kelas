<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: ../auth/login.php");
}

include '../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $deadline = $_POST['deadline'];

    mysqli_query($conn, "INSERT INTO proyek 
    (nama_proyek, deskripsi, deadline) 
    VALUES 
    ('$nama','$deskripsi','$deadline')");

    header("Location: tambah_proyek.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Proyek</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#ebe1d3;
}

.main{
    margin-left:240px;
    padding:40px;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.form-box{
    width:100%;
    max-width:650px;
    background:#f7efe5;
    padding:40px;
    border-radius:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.form-box h1{
    color:#3e2f24;
    margin-bottom:30px;
    font-size:36px;
}

.input-group{
    margin-bottom:22px;
}

.input-group label{
    display:block;
    margin-bottom:10px;
    color:#5c4635;
    font-weight:600;
}

.input-group input,
.input-group textarea{
    width:100%;
    padding:16px;
    border:none;
    border-radius:16px;
    background:#fff;
    font-size:15px;
    outline:none;
}

.input-group textarea{
    min-height:140px;
    resize:none;
}

button{
    width:100%;
    padding:16px;
    border:none;
    border-radius:16px;
    background:#b68d69;
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#9f7653;
}

</style>

</head>

<body>

<div class="sidebar">

    <div class="logo">
        <h2>DeadlineHub</h2>
    </div>

    <div class="menu">

        <a href="index.php">Dashboard</a>

        <a href="tambah_proyek.php" class="active">
            Proyek</a>
        <a href="tambah_tugas.php">Tugas</a>

        <a href="laporan.php">Laporan</a>

        <a href="../auth/logout.php">Logout</a>

    </div>

</div>

<div class="main">

    <div class="form-box">

        <h1>Tambah Proyek </h1>

        <form method="POST">

            <div class="input-group">

                <label>Nama Proyek</label>

                <input 
                type="text" 
                name="nama_proyek"
                placeholder="Contoh: Website Absensi"
                required>

            </div>

            <div class="input-group">

                <label>Deskripsi</label>

                <textarea 
                name="deskripsi"
                placeholder="Masukkan deskripsi proyek..."
                required></textarea>

            </div>

            <div class="input-group">

                <label>Deadline</label>

                <input 
                type="date" 
                name="deadline"
                required>

            </div>

            <div class="input-group">
                <label>Progress (%)</label>

                <input 
                    type="range" 
                    name="progress" 
                    min="0" 
                    max="100" 
                    value="50"
                    oninput="this.nextElementSibling.value = this.value + '%'"
                >

                <output>50%</output>
            </div>

            <button type="submit" name="simpan">
                Simpan Proyek
            </button>

        </form>

    </div>

</div>

</body>
</html>