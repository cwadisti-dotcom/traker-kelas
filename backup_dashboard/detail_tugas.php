<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['username'])){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

$query = mysqli_query($conn, "
    SELECT tugas.*, proyek.nama_proyek 
    FROM tugas
    LEFT JOIN proyek ON tugas.proyek_id = proyek.id
    WHERE tugas.id='$id'
");

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tugas</title>

    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<div class="sidebar">
    <div class="logo">
        <h2>DeadlineHub</h2>
    </div>

    <div class="menu">
        <a href="index.php">Dashboard</a>
        <a href="tambah_proyek.php">Proyek</a>
        <a href="tambah_tugas.php" class="active">Tugas</a>
        <a href="laporan.php">Laporan</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="main">

    <div class="form-card">

        <h1>Detail Tugas </h1>
        <p>Informasi lengkap tugas.</p>

        <div class="detail-box">

            <div class="detail-item">
                <span>Nama Tugas</span>
                <h3><?php echo $data['nama_tugas']; ?></h3>
            </div>

            <div class="detail-item">
                <span>Deadline</span>
                <h3><?php echo $data['deadline']; ?></h3>
            </div>

            <div class="detail-item">
                <span>Prioritas</span>
                <h3><?php echo $data['prioritas']; ?></h3>
            </div>

            <div class="detail-item">
                <span>Proyek</span>
                <h3><?php echo $data['nama_proyek']; ?></h3>
            </div>

        </div>

        <div class="detail-action">

            <a href="edit_tugas.php?id=<?php echo $data['id']; ?>" class="btn-edit">
                Edit
            </a>

            <a href="tambah_tugas.php" class="btn-back">
                Kembali
            </a>

        </div>

    </div>

</div>

</body>
</html>