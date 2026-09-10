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

    <?php include __DIR__ . '/sidebar.php'; ?>

    <!-- MAIN -->
    <main class="main-content">

        <div class="topbar">
            <div class="profile">

                <div class="user-box">

                    <div class="user-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <span><?= htmlspecialchars($_SESSION['username']); ?></span>

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

                <?php while($row = mysqli_fetch_assoc($riwayat)): ?>

                <tr>

                    <td><?= htmlspecialchars($row['nama_tugas']); ?></td>

                    <td>
                        <?= !empty($row['nama_mapel'])
                            ? htmlspecialchars($row['nama_mapel'])
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
