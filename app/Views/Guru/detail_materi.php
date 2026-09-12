<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Viewer Materi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="theme-guru">
<div class="wrapper">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <div class="main-content">
        <div class="content-box">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Viewer Materi</h1>
                    <p class="page-subtitle"><?= htmlspecialchars($materi['judul'] ?? ''); ?></p>
                </div>
                <a href="materi.php" class="btn-primary" style="text-decoration: none;">&larr; Kembali</a>
            </div>

            <div class="table-box">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username Siswa</th>
                            <th>Waktu Melihat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if ($viewers && mysqli_num_rows($viewers) > 0):
                            while ($v = mysqli_fetch_assoc($viewers)): 
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($v['username']); ?></td>
                                <td><?= date('d M Y - H:i', strtotime($v['dibuka_pada'])); ?> WIB</td>
                            </tr>
                        <?php 
                            endwhile;
                        else:
                        ?>
                            <tr>
                                <td colspan="3" style="text-align: center;">Belum ada siswa yang melihat materi ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>