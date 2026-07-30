<?php

include '../config/koneksi.php';

$total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM tugas");
$total = mysqli_fetch_assoc($total_query)['total'];

$total_selesai_query = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM tugas 
    WHERE progress >= 100
");

$total_selesai = mysqli_fetch_assoc($total_selesai_query)['total'];

$total_belum_query = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM tugas 
    WHERE progress < 100
");

$total_belum = mysqli_fetch_assoc($total_belum_query)['total'];

$query = mysqli_query($conn, "
    SELECT 
        tugas.*,
        proyek.nama_proyek
    FROM tugas
    LEFT JOIN proyek
    ON tugas.proyek_id = proyek.id
    ORDER BY tugas.deadline ASC
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>

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
        <a href="laporan.php" class="active">Laporan</a>
        <a href="../auth/logout.php">Logout</a>
    </div>

</div>

<div class="main-content">

    <div class="hero-section">
        <h1>Laporan Tugas 📋</h1>
        <p>Semua laporan tugas sekolah kamu.</p>
    </div>

    <div class="report-stats">

        <div class="stat-card">
            <h2><?= $total ?></h2>
            <p>Total Tugas</p>
        </div>

        <div class="stat-card">
            <h2><?= $total_selesai ?></h2>
            <p>Tugas Selesai</p>
        </div>

        <div class="stat-card">
            <h2><?= $total_belum ?></h2>
            <p>Belum Selesai</p>
        </div>

    </div>

    <div class="report-table-box">

        <div class="table-header">

            <h2>Daftar Laporan</h2>

            <button onclick="window.print()" class="print-btn">
                Print Laporan
            </button>

        </div>

        <table class="report-table">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Nama Tugas</th>
                    <th>Proyek</th>
                    <th>Deadline</th>
                    <th>Prioritas</th>
                    <th>Progress</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

            <?php
            $no = 1;

            while($data = mysqli_fetch_assoc($query)) {
            ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td>
                        <?= $data['nama_tugas'] ?>
                    </td>

                    <td>
                        <?= $data['nama_proyek'] ?>
                    </td>

                    <td>
                        <?= $data['deadline'] ?>
                    </td>

                    <td>

                        <span class="priority-badge">
                            <?= $data['prioritas'] ?>
                        </span>

                    </td>

                    <td width="220">

                        <div class="progress-bar">

                            <div class="progress-fill"
                            style="width: <?= $data['progress'] ?>%;">
                            </div>

                        </div>

                        <small><?= $data['progress'] ?>%</small>

                    </td>

                    <td>

                        <?php if($data['progress'] >= 100){ ?>

                            <span class="status selesai">
                                Selesai
                            </span>

                        <?php } else { ?>

                            <span class="status belum">
                                Belum
                            </span>

                        <?php } ?>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>