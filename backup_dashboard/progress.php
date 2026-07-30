<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['username'])){
    header("Location: ../auth/login.php");
    exit();
}

$query = mysqli_query($conn, "
    SELECT tugas.*, proyek.nama_proyek 
    FROM tugas
    LEFT JOIN proyek ON tugas.proyek_id = proyek.id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress</title>

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
        <a href="tambah_tugas.php">Tugas</a>
        <a href="laporan.php">Laporan</a>
        <a href="../auth/logout.php">Logout</a>
    </div>

</div>

<div class="main-content">

    <div class="hero-section">
        <h1>Progress Tugas 📈</h1>
        <p>Lihat perkembangan semua tugas kamu.</p>
    </div>

    <div class="task-grid">

        <?php while($row = mysqli_fetch_assoc($query)) { ?>

        <div class="task-card">

            <h2><?php echo $row['nama_tugas']; ?></h2>

            <p class="project-name">
                <?php echo $row['nama_proyek']; ?>
            </p>

            <div class="priority-badge">
                <?php echo $row['prioritas']; ?>
            </div>

            <div class="deadline-box">
                📅 <?php echo $row['deadline']; ?>
            </div>

            <div class="progress-area">

                <div class="progress-text">
                    <span>Progress</span>
                    <span><?php echo $row['progress']; ?>%</span>
                </div>

                <div class="progress-bar">
                    <div 
                        class="progress-fill"
                        style="width: <?php echo $row['progress']; ?>%;">
                    </div>
                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>