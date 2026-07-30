<?php
include '../config/koneksi.php';

$totalGuru = mysqli_num_rows(
    mysqli_query($koneksi,
    "SELECT * FROM users WHERE role='guru'")
);

$totalSiswa = mysqli_num_rows(
    mysqli_query($koneksi,
    "SELECT * FROM users WHERE role='siswa'")
);

$totalTugas = mysqli_num_rows(
    mysqli_query($koneksi,
    "SELECT * FROM tugas")
);
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="../assets/css/admin.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="container">

    <?php include 'sidebar.php'; ?>

    <div class="content">

        <!-- TOPBAR -->

        <div class="topbar">

            <div class="topbar-right">

                <div class="notification">
                    <i class="fa-regular fa-bell"></i>
                </div>

                <div class="user-box">

                    <div class="user-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <span>Admin</span>

                </div>

            </div>

        </div>

        <!-- PAGE TITLE -->

        <div class="page-title">

            <h1>Dashboard Admin</h1>

            <p>
                Kelola seluruh data sistem DeadlineHub.
            </p>

        </div>

        <!-- STAT CARD -->

        <div class="stats-grid">

            <div class="stat-card">

                <div class="card-icon">
                    <i class="fa-solid fa-user-tie"></i>
                </div>

                <h2><?= $totalGuru; ?></h2>
                <h3>Total Guru</h3>
                <p>Guru yang terdaftar</p>

            </div>

            <div class="stat-card">

                <div class="card-icon green">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>

                <h2><?= $totalSiswa; ?></h2>
                <h3>Total Siswa</h3>
                <p>Siswa yang terdaftar</p>

            </div>

            <div class="stat-card">

                <div class="card-icon orange">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>

                <h2><?= $totalTugas; ?></h2>
                <h3>Total Tugas</h3>
                <p>Tugas yang tersedia</p>

            </div>

        </div>

        <!-- MONITORING CEPAT -->

        <div class="table-card">

            <h2 style="margin-bottom:20px;">
                Monitoring Cepat
            </h2>

            <table class="monitor-table">

                <thead>

                    <tr>

                        <th>Nama Tugas</th>
                        <th>Deadline</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                <?php

                $tugas = mysqli_query(
                    $koneksi,
                    "SELECT * FROM tugas
                    ORDER BY deadline ASC
                    LIMIT 5"
                );

                while($row = mysqli_fetch_assoc($tugas)):

                ?>

                <tr>

                    <td>
                        <?= $row['nama_tugas']; ?>
                    </td>

                    <td>
                        <?= date(
                            'd M Y',
                            strtotime($row['deadline'])
                        ); ?>
                    </td>

                    <td>

                        <span class="status-badge">

                            <?= $row['status']; ?>

                        </span>

                    </td>

                </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>