<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - DeadlineHub</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body class="theme-siswa">

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <h1 class="page-title">Dashboard Siswa</h1>
            <p class="page-subtitle">Selamat datang, <?= htmlspecialchars($_SESSION['username']); ?>!</p>

            <div class="stats-grid">

                <div class="stat-card">
                    <div class="stat-icon bg-blue">
                        <i class="fa-solid fa-book"></i>
                    </div>
                    <h2><?= $totalTugas; ?></h2>
                    <h3>Total Tugas</h3>
                    <p>Jumlah semua tugas dari guru</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h2><?= $tugasSelesai; ?></h2>
                    <h3>Tugas Selesai</h3>
                    <p>Tugas yang sudah dikumpulkan</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-yellow">
                        <i class="fa-regular fa-hourglass-half"></i>
                    </div>
                    <h2><?= $belumSelesai; ?></h2>
                    <h3>Belum Selesai</h3>
                    <p>Tugas yang belum dikumpulkan</p>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-red">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <h2><?= $terlambat; ?></h2>
                    <h3>Perlu Dikumpulkan</h3>
                    <p>Melewati deadline</p>
                </div>

            </div>

            <!-- TUGAS TERDEKAT -->

            <div class="section-header">
                <h2>Tugas Terdekat</h2>
                <a href="tugas_saya.php">Lihat semua</a>
            </div>

            <div class="table-box">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Tugas</th>
                            <th>Mapel</th>
                            <th>Deadline</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($tugas = mysqli_fetch_assoc($tugasTerdekat)): ?>
                        <tr>
                            <td><?= htmlspecialchars($tugas['nama_tugas']); ?></td>
                            <td><?= !empty($tugas['nama_mapel']) ? htmlspecialchars($tugas['nama_mapel']) : '-'; ?></td>
                            <td><?= date('d M Y', strtotime($tugas['deadline'])); ?></td>
                            <td>
                                <span class="badge progress">
                                    <?= htmlspecialchars($tugas['status_siswa']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- JADWAL PELAJARAN -->

            <div class="section-header">
                <h2>Jadwal Pelajaran</h2>
                <span class="section-tag">Semester Genap</span>
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
                        <td colspan="5" class="istirahat">DOA</td>
                    </tr>

                    <tr>
                        <td>07:00 - 07:45</td>
                        <td class="soft-gray">UPCR</td>
                        <td rowspan="3" class="soft-olive">PBO II</td>
                        <td rowspan="2" class="soft-olive">KOKURIKULER</td>
                        <td rowspan="2" class="soft-olive">PROWEB</td>
                        <td class="soft-gray">DOA/BERSIH</td>
                    </tr>

                    <tr>
                        <td>07:45 - 08:30</td>
                        <td rowspan="2" class="soft-olive">PROWEB</td>
                        <td rowspan="3" class="soft-green2">INA</td>
                    </tr>

                    <tr>
                        <td>08:30 - 09:15</td>
                        <td class="soft-green">BK</td>
                        <td rowspan="2" class="soft-mint">PENJAS</td>
                    </tr>

                    <tr>
                        <td>09:15 - 10:00</td>
                        <td class="soft-blue">PANCASILA</td>
                        <td class="soft-gray">MTK</td>
                        <td class="soft-gray">PROPGR</td>
                    </tr>

                    <tr>
                        <td>10:00 - 10:15</td>
                        <td colspan="5" class="istirahat">ISTIRAHAT</td>
                    </tr>

                    <tr>
                        <td>10:15 - 11:00</td>
                        <td class="soft-blue">PANCASILA</td>
                        <td rowspan="2" class="soft-gray">MTK</td>
                        <td rowspan="2" class="soft-pink">SEJ</td>
                        <td rowspan="2" class="soft-lime">PROPGR</td>
                        <td rowspan="2" class="soft-pink2">ENG</td>
                    </tr>

                    <tr>
                        <td>11:00 - 11:45</td>
                        <td class="soft-lime">PROPGR</td>
                    </tr>

                    <tr>
                        <td>11:45 - 12:30</td>
                        <td colspan="5" class="istirahat">ISHOMA</td>
                    </tr>

                    <tr>
                        <td>12:30 - 13:15</td>
                        <td rowspan="3" class="soft-yellow">DS I</td>
                        <td rowspan="3" class="soft-yellow2">KIK</td>
                        <td rowspan="3" class="soft-green3">AGAMA</td>
                        <td rowspan="3" class="soft-olive">BD</td>
                        <td class="soft-pink2">ENG</td>
                    </tr>

                    <tr>
                        <td>13:15 - 14:00</td>
                        <td class="soft-green">JPN</td>
                    </tr>

                    <tr>
                        <td>14:00 - 14:45</td>
                    </tr>

                    </tbody>

                </table>
            </div>

        </div>

    </div>

</div>

</body>
</html>
