<?php
include '../config/koneksi.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Saya</title>

    <link rel="stylesheet" href="../assets/css/siswa.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
     <aside class="sidebar">

        <div class="sidebar-top">

            <div class="logo">
                <h2>DeadlineHub</h2>
            </div>

            <div class="menu-title">
                SISWA
            </div>

            <ul class="menu">

                <!-- DASHBOARD -->
                <li class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
                    <a href="index.php">
                        <i class="fa-solid fa-table-columns"></i>
                        Dashboard
                    </a>
                </li>

                <li class="<?= $current_page == 'tugas_saya.php' ? 'active' : '' ?>">
                    <a href="tugas_saya.php">
                        <i class="fa-regular fa-clipboard"></i>
                        Tugas Aing
                    </a>
                </li>

                <li class="<?= $current_page == 'nilai.php' ? 'active' : '' ?>">
                    <a href="nilai.php">
                        <i class="fa-solid fa-chart-column"></i>
                        Nilai
                    </a>
                </li>
            </ul>

        </div>

        <ul class="menu">

            <li class="logout">
                <a href="../auth/logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- MAIN -->
    <main class="main-content">

        <div class="topbar">

            <div class="profile">
                <div class="user-box">

                    <div class="user-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <span>Siswa</span>

                </div>
            </div>

        </div>

        <div class="page-title">
            <h1>Tugas Saya</h1>
            <p>Daftar tugas yang harus dikerjakan.</p>
        </div>

        <div class="task-grid">

            <?php

               session_start();

                $siswa = $_SESSION['username'];

                $tugas = mysqli_query(
                    $koneksi,
                    "SELECT *
                    FROM tugas
                    WHERE id NOT IN (
                        SELECT tugas_id
                        FROM pengumpulan_tugas
                        WHERE siswa='$siswa'
                    )
                    ORDER BY deadline ASC"
                );
                 while($row = mysqli_fetch_assoc($tugas)):

                ?>

                <div class="task-card">

                    <div class="task-card-top">

                        <span class="mapel">
                            <?= $row['mapel']; ?>
                        </span>

                        <span class="status progress">
                            <?= $row['status']; ?>
                        </span>

                    </div>

                    <h3><?= $row['nama_tugas']; ?></h3>

                    <div class="task-info">

                        <p>
                            <i class="fa-solid fa-user"></i>
                            <?= !empty($row['guru']) ? $row['guru'] : 'Guru'; ?>
                        </p>

                        <p>
                            <i class="fa-regular fa-clock"></i>
                            <?= date('d M Y', strtotime($row['deadline'])); ?>
                        </p>

                    </div>

                    <div class="progress-box">

                        <div class="progress-title">

                            <span>Progress</span>

                            <span>
                                <?= $row['progress']; ?>%
                            </span>

                        </div>

                        <div class="progress-bar">

                            <div
                                class="progress-fill"
                                style="width: <?= $row['progress']; ?>%">
                            </div>

                        </div>

                    </div>

                    <div class="task-action">

                        <a href="upload_tugas.php?id=<?= $row['id']; ?>"
                        class="btn-upload">

                            Upload Jawaban

                        </a>

                    </div>

                </div>

                <?php endwhile; ?>
            </div>

        </div>

    </main>

</div>

</body>
</html>