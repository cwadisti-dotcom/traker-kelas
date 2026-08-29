<?php
include '../config/koneksi.php';

$siswa = 'siswa1';

$totalTugas = mysqli_num_rows(
    mysqli_query($koneksi,"SELECT * FROM tugas")
);

$tugasTerdekat = mysqli_query(
    $koneksi,
    "SELECT
        t.*,
        COALESCE(p.status,'Belum Upload') as status_siswa
    FROM tugas t
    LEFT JOIN pengumpulan_tugas p
        ON t.id = p.tugas_id
        AND p.siswa = '$siswa'
    ORDER BY t.deadline ASC
    LIMIT 5"
);

$tugasSelesai = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT *
        FROM pengumpulan_tugas
        WHERE siswa='$siswa'
        AND status='Sudah Dinilai'"
    )
);

$belumSelesai = $totalTugas - $tugasSelesai;

if($belumSelesai < 0){
    $belumSelesai = 0;
}

$terlambat = mysqli_num_rows(
    mysqli_query(
        $koneksi,
        "SELECT t.*
        FROM tugas t
        LEFT JOIN pengumpulan_tugas p
            ON t.id = p.tugas_id
            AND p.siswa='$siswa'
        WHERE t.deadline < CURDATE()
        AND p.id IS NULL"
    )
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Siswa - DeadlineHub</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/siswa.css">

    <!-- ICON -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->

   <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>

    <aside class="sidebar">

        <div class="sidebar-top">

            <div class="logo">
                <h2>DeadlineHub</h2>
            </div>

            <div class="menu-title">SISWA</div>

            <ul class="menu">

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
                    <span>Logout</span>
                </a>
            </li>
        </ul>

    </aside>


    <!-- MAIN -->
    <main class="main-content">

        <!-- TAMBAHKAN DI DALAM <main class="main-content"> -->

        <div class="topbar">
            
            <div class="profile">

                <i class="fa-regular fa-bell"></i>

                <div class="user-box">
                    <div class="user-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <span>Siswa</span>
                </div>

            </div>

        </div>

        <div class="page-title">
            <h1>Dashboard Siswa</h1>
            <p>Selamat datang, Siswa! </p>
        </div>

        <!-- CARD -->
        <div class="card-container">

            <div class="card card-purple">

                <div class="card-icon">
                    <i class="fa-regular fa-clipboard"></i>
                </div>

                <h2><?= $totalTugas; ?></h2>
                <h3>Total Tugas</h3>

                <p>Jumlah semua tugas simple abiz dari guru</p> 

            </div>

            <div class="card card-green">

                <div class="card-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <h2><?= $tugasSelesai; ?></h2>
                <h3>Tugas Selesai</h3>
                <p>Tugas yang sudah dikumpulkan</p>

            </div>

            <div class="card card-orange">

                <div class="card-icon">
                    <i class="fa-regular fa-hourglass-half"></i>
                </div>

                <h2><?= $belumSelesai; ?></h2>
                <h3>Belum Selesai</h3>
                <p>Tugas yang belum dikumpulkan</p>

            </div>

            <div class="card card-blue">

                <div class="card-icon">
                    <i class="fa-regular fa-file-lines"></i>
                </div>

                <h2><?= $terlambat; ?></h2> 
                <h3>Perlu Dikumpulkan</h3>
                <p>Melewati deadline</p>

            </div>

        </div>

        <!-- JADWAL PELAJARAN -->

        <div class="jadwal-section">

            <div class="jadwal-header">

                <h2>Jadwal Pelajaran </h2>

                <span>Semester Genap</span>

            </div>

            <div class="jadwal-table">

                <table>

                    <thead>
                        <tr>
                            <th>Jam</th>
                            <th>Senin</th>
                            <th>Selasa</th>
                            <th>Rabu</th>
                            <th>Kamis</th>
                            <th>Jumat</th>
                        </tr>
                    </thead>

                    <tbody>

                    <tr>
                        <td>06:30 - 07:00</td>

                        <td colspan="5" class="istirahat">
                            DOA
                        </td>
                    </tr>

                    <tr>
                        <td>07:00 - 07:45</td>

                        <td class="mapel soft-gray">UPCR</td>

                        <td rowspan="3" class="mapel soft-olive">
                            PBO II
                        </td>

                        <td rowspan="2" class="mapel soft-olive">
                            KOKURIKULER
                        </td>

                       <td rowspan="2" class="mapel soft-olive">
                            PROWEB
                        </td>

                        <td class="mapel soft-gray">
                            DOA/BERSIH
                        </td>
                    </tr>

                    <tr>
                        <td>07:45 - 08:30</td>

                        <td rowspan="2" class="mapel soft-olive">
                            PROWEB
                        </td>

                        <td rowspan="3" class="mapel soft-green2">
                            INA
                        </td>
                    </tr>

                    <tr>
                        <td>08:30 - 09:15</td>
                        <td class="mapel soft-green">
                            BK
                        </td>

                        <td rowspan="2" class="mapel soft-mint">
                            PENJAS
                        </td>
                        
                    </tr>

                    <tr>
                        <td>09:15 - 10:00</td>
                        <td class="mapel soft-blue">
                            PANCASILA
                        </td>

                        <td class="mapel soft-gray">
                            MTK
                        </td>
                         <td class="mapel soft-gray">
                            PROPGR
                        </td>

                        
                        
                    </tr>

                    <tr>
                        <td>10:00 - 10:15</td>

                        <td colspan="5" class="istirahat">
                            ISTIRAHAT 
                        </td>
                    </tr>

                    <tr>
                        <td>10:15 - 11:00</td>

                        <td class="mapel soft-blue">
                            PANCASILA
                        </td>

                        <td rowspan="2" class="mapel soft-gray">
                            MTK
                        </td>

                        <td rowspan="2" class="mapel soft-pink">
                            SEJ
                        </td>

                        <td rowspan="2" class="mapel soft-lime">
                            PROPGR
                        </td>

                        <td rowspan="2" class="mapel soft-pink2">
                            ENG
                        </td>
                    </tr>

                    <tr>
                        <td>11:00 - 11:45</td>

                        <td class="mapel soft-lime">
                            PROPGR
                        </td>
                    </tr>

                    <tr>
                        <td>11:45 - 12:30</td>

                        <td colspan="5" class="istirahat">
                            ISHOMA 
                        </td>
                    </tr>

                    <tr>
                        <td>12:30 - 13:15</td>

                        <td rowspan="3" class="mapel soft-yellow">
                            DS I
                        </td>

                        <td rowspan="3" class="mapel soft-yellow2">
                            KIK
                        </td>

                        <td rowspan="3" class="mapel soft-green3">
                            AGAMA
                        </td>

                        <td rowspan="3" class="mapel soft-olive">
                            BD
                        </td>

                        <td class="mapel soft-pink2">
                            ENG
                        </td>
                    </tr>

                    <tr>
                        <td>13:15 - 14:00</td>

                        <td class="mapel soft-green">
                            JPN
                        </td>
                    </tr>

                    <tr>
                        <td>14:00 - 14:45</td>

                    </tr>

                    </tbody>

                </table>

            </div>

        </div>




        <!-- TASK -->
        <div class="task-wrapper">

            <!-- TUGAS TERDEKAT -->

            <div class="task-box">

                <div class="task-header">
                    <h2>Tugas Terdekat</h2>
                    <a href="tugas_saya.php">Lihat semua</a>
                </div>

               <?php while($tugas = mysqli_fetch_assoc($tugasTerdekat)): ?>

                <div class="task-item">

                    <h3><?= $tugas['nama_tugas']; ?></h3>

                    <p>
                        <i class="fa-solid fa-user"></i>
                        <?= !empty($tugas['guru']) ? $tugas['guru'] : 'Guru'; ?>
                    </p>

                    <p>
                        <i class="fa-regular fa-clock"></i>
                        Deadline:
                        <?= date('d M Y', strtotime($tugas['deadline'])); ?>
                    </p>

                    <span class="badge progress">
                        <?= $tugas['status_siswa']; ?>
                    </span>

                </div>

                <hr>

<?php endwhile; ?>
                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>