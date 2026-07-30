<?php
session_start();

include "../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM proyek WHERE id='$id'");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detail Proyek</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family:'Poppins',sans-serif;
    background:#ebe1d3;
    padding:40px;
}

.card{
    background:#f7efe5;
    padding:35px;
    border-radius:30px;
    max-width:700px;
    margin:auto;
}

h1{
    color:#3e2f24;
    margin-bottom:20px;
}

p{
    color:#6d5a4a;
    line-height:1.8;
}

.deadline{
    margin-top:20px;
    display:inline-block;
    background:white;
    padding:12px 18px;
    border-radius:14px;
}

a{
    display:inline-block;
    margin-top:30px;
    text-decoration:none;
    background:#b68d69;
    color:white;
    padding:12px 18px;
    border-radius:14px;
}

</style>

</head>

<body>

<div class="card">

    <h1>
        <?php echo $row['nama_proyek']; ?>
    </h1>

    <p>
        <?php echo $row['deskripsi']; ?>
    </p>

    <div class="deadline">
        📅 <?php echo $row['deadline']; ?>
    </div>

    <br>

    <a href="tambah_proyek.php">
        ← Kembali
    </a>

</div>

</body>
</html>
