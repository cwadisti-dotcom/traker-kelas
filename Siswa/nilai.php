<?php
include '../config/koneksi.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Saya</title>

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
                        Tugas Saya
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
            <h1>Nilai Saya</h1>
            <p>Riwayat nilai tugas yang sudah dinilai guru.</p>
        </div>

        <div class="nilai-table">

            <table>

                <thead>
                    <tr>
                        <th>Tugas</th>
                        <th>Mapel</th>
                        <th>Status</th>
                        <th>Nilai</th>
                    </tr>
                </thead>

                <tbody>

                <?php

                $siswa = "siswa1";

                $query = mysqli_query(
                    $koneksi,
                    "SELECT
                        pengumpulan_tugas.nilai,
                        pengumpulan_tugas.status,
                        tugas.nama_tugas,
                        tugas.mapel
                    FROM pengumpulan_tugas
                    JOIN tugas
                        ON tugas.id = pengumpulan_tugas.tugas_id
                    WHERE pengumpulan_tugas.siswa = '$siswa'
                    ORDER BY pengumpulan_tugas.id DESC"
                );

                while($row = mysqli_fetch_assoc($query)):

                ?>

                <tr>

                    <td><?= $row['nama_tugas']; ?></td>

                    <td>
                        <?= !empty($row['mapel'])
                            ? $row['mapel']
                            : '-'; ?>
                    </td>

                    <td>

                        <?php if($row['status'] == 'Sudah Dinilai'): ?>

                            <span class="badge badge-success">
                                Sudah Dinilai
                            </span>

                        <?php else: ?>

                            <span class="badge badge-warning">
                                Belum Dinilai
                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <?= $row['nilai'] > 0
                            ? $row['nilai']
                            : '-'; ?>

                    </td>

                </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </main>

</div>

</body>
</html>