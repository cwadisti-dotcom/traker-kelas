<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Dashboard Guru</title>

    <link rel="stylesheet" href="../assets/css/guru.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="wrapper">

    <?php include 'sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <div class="topbar">


                <div class="profile-box">

                    <div class="profile-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    Guru

                </div>

            </div>

            <h1 class="page-title">
                Dashboard Guru
            </h1>

            <p class="page-subtitle">
                Pantau tugas dan aktivitas siswa dengan lebih gampang.
            </p>

            <div class="stats-grid">

                <div class="stat-card">

                    <div class="stat-icon bg-purple">
                        <i class="fa-solid fa-book"></i>
                    </div>

                    <h2><?= $totalTugas ?></h2>

                    <h3>Total Tugas</h3>

                    <p>
                        Jumlah tugas yang sudah dibuat
                    </p>

                </div>

                <div class="stat-card">

                    <div class="stat-icon bg-green">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <h2><?= $totalUpload ?></h2>

                    <h3>Sudah Upload</h3>

                    <p>
                        Jawaban siswa sudah terkumpul
                    </p>

                </div>

                <div class="stat-card">

                    <div class="stat-icon bg-yellow">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <h2><?= $totalBelumDinilai ?></h2>

                    <h3>Belum Upload</h3>

                    <p>
                        Siswa belum mengumpulkan
                    </p>

                </div>

                <div class="stat-card">

                    <div class="stat-icon bg-blue">
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <h2><?= $totalDinilai ?></h2>

                    <h3>Sudah Dinilai</h3>

                    <p>
                        Tugas sudah diberi nilai
                    </p>

                </div>

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

                    <tbody>

                    <?php while($row = mysqli_fetch_assoc($tugas)): ?>

                    <tr>

                        <td><?= $row['nama_tugas']; ?></td>

                        <td>
                            <?= !empty($row['mapel']) ? $row['mapel'] : '-'; ?>
                        </td>

                        <td>
                            <?= date('d M Y', strtotime($row['deadline'])); ?>
                        </td>

                        <td><?= $row['status']; ?></td>

                    </tr>

                    <?php endwhile; ?>

                    </tbody>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>