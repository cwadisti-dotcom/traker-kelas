<?php
include '../config/koneksi.php';

if(isset($_POST['simpan_nilai'])){

    $id = $_POST['id'];
    $nilai = $_POST['nilai'];

    mysqli_query(
        $koneksi,
        "UPDATE pengumpulan_tugas
        SET nilai='$nilai',
        status='Sudah Dinilai'
        WHERE id='$id'"
    );

    header("Location:nilai.php");
    exit;
}

$sudahDinilai = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT * FROM pengumpulan_tugas
        WHERE nilai > 0"
    )
);

$belumDinilai = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT * FROM pengumpulan_tugas
        WHERE nilai = 0
        OR nilai IS NULL"
    )
);

$jawabanMasuk = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT * FROM pengumpulan_tugas"
    )
);

$totalSiswa = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT * FROM users
        WHERE role='siswa'"
    )
);
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Input Nilai</title>

    <link rel="stylesheet" href="../assets/css/guru.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="wrapper">

    <?php include 'sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <!-- TOPBAR -->

            <div class="topbar">

                <div class="profile-box">

                    <div class="profile-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    Guru

                </div>

            </div>

            <!-- TITLE -->

            <h1 class="page-title">
                Input Nilai
            </h1>

            <p class="page-subtitle">
                Berikan nilai untuk tugas yang sudah dikumpulkan siswa.
            </p>

            <!-- STATS -->

            <div class="stats-grid">

                <div class="stat-card">

                    <div class="stat-icon bg-purple">
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <<h2><?= $sudahDinilai ?></h2>

                    <h3>Sudah Dinilai</h3>

                    <p>
                        Tugas yang sudah diberi nilai
                    </p>

                </div>

                <div class="stat-card">

                    <div class="stat-icon bg-yellow">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <h2><?= $belumDinilai ?></h2>   

                    <h3>Belum Dinilai</h3>

                    <p>
                        Tugas menunggu penilaian
                    </p>

                </div>

                <div class="stat-card">

                    <div class="stat-icon bg-green">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <h2><?= $jawabanMasuk ?></h2>

                    <h3>Jawaban Masuk</h3>

                    <p>
                        Jawaban berhasil dikumpulkan
                    </p>

                </div>

                <div class="stat-card">

                    <div class="stat-icon bg-blue">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <h2><?= $totalSiswa ?></h2>

                    <h3>Total Siswa</h3>

                    <p>
                        Jumlah siswa aktif
                    </p>

                </div>

            </div>

            <!-- TABLE -->

            <div class="table-box">

                <table>

                    <thead>

                        <tr>

                            <th>Nama Siswa</th>
                            <th>Tugas</th>
                            <th>Mapel</th>
                            <th>Nilai</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $data = mysqli_query(
                            $koneksi,
                            "SELECT
                                pengumpulan_tugas.*,
                                tugas.nama_tugas,
                                tugas.mapel
                            FROM pengumpulan_tugas
                            LEFT JOIN tugas
                            ON pengumpulan_tugas.tugas_id = tugas.id
                            ORDER BY pengumpulan_tugas.tanggal_upload DESC"
                        );

                        while($row = mysqli_fetch_assoc($data)):

                        ?>

                        <tr>

                        <form method="POST">

                            <input
                                type="hidden"
                                name="id"
                                value="<?= $row['id']; ?>"
                            >

                            <td>
                                <?= $row['siswa']; ?>
                            </td>

                            <td>
                                <?= $row['nama_tugas']; ?>
                            </td>

                            <td>
                                <?= !empty($row['mapel']) ? $row['mapel'] : '-'; ?>
                            </td>

                            <td>

                                <input
                                    type="number"
                                    class="input-nilai"
                                    name="nilai"
                                    min="0"
                                    max="100"
                                    value="<?= $row['nilai']; ?>"
                                >

                            </td>

                            <td>

                                <button
                                    type="submit"
                                    name="simpan_nilai"
                                    class="action-btn edit-btn"
                                >
                                    Simpan
                                </button>

                            </td>

                        </form>

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