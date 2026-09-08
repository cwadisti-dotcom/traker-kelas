<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Tugas</title>
    <link rel="stylesheet" href="../assets/css/guru.css">
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <h1 class="page-title">
                Monitoring
            </h1>

            <p class="page-subtitle">
                Pantau progress pengumpulan tugas siswa.
            </p>

            <div class="stats-grid">

                <div class="stat-card">

                    <div class="stat-icon bg-green">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <h2><?= $totalUpload ?></h2>

                    <h3>Sudah Upload</h3>

                    <p>
                        Jawaban sudah terkumpul
                    </p>

                </div>

                <div class="stat-card">

                    <div class="stat-icon bg-yellow">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <h2><?= $totalBelumUpload ?></h2>

                    <h3>Belum Upload</h3>

                    <p>
                        Siswa belum upload
                    </p>

                </div>

                <div class="stat-card">

                    <div class="stat-icon bg-blue">
                        <i class="fa-solid fa-file"></i>
                    </div>

                    <h2><?= $totalTugasAktif ?></h2>

                    <h3>Tugas Aktif</h3>

                    <p>
                        Tugas yang masih berjalan
                    </p>

                </div>

                <div class="stat-card">

                    <div class="stat-icon bg-purple">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <h2><?= $totalSiswa ?></h2>

                    <h3>Total Siswa</h3>

                    <p>
                        Jumlah siswa aktif
                    </p>

                </div>

            </div>

            <div class="table-box">

                <table>

                    <thead>

                        <tr>

                            <th>Nama Siswa</th>
                            <th>Tugas</th>
                            <th>File</th>
                            <th>Status</th>
                            <th>Waktu Upload</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    while($row = mysqli_fetch_assoc($monitor)):

                    ?>

                    <tr>

                        <td><?= $row['siswa']; ?></td>

                        <td>
                            <?= $row['nama_tugas']; ?>
                        </td>

                        <td>

                            <?php
                            if(!empty($row['file_jawaban'])){
                                echo $row['file_jawaban'];
                            }else{
                                echo '-';
                            }
                            ?>

                        </td>

                        <td>

                            <?php
                            if(!empty($row['file_jawaban'])){
                                echo 'Sudah Upload';
                            }else{
                                echo 'Belum Upload';
                            }
                            ?>

                        </td>

                        <td>

                            <?= date(
                                'd M Y',
                                strtotime($row['tanggal_upload'])
                            ); ?>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>