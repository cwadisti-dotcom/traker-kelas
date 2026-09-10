<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Saya</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body class="theme-siswa">

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <h1 class="page-title">Nilai Saya</h1>
            <p class="page-subtitle">Riwayat nilai tugas yang sudah dinilai guru.</p>

            <div class="table-box">
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
                                <span class="badge badge-success">Sudah Dinilai</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Belum Dinilai</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= $row['nilai'] > 0 ? $row['nilai'] : '-'; ?>
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
