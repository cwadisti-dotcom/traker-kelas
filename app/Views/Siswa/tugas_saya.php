<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Saya</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body class="theme-siswa">

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <h1 class="page-title">Tugas Saya</h1>
            <p class="page-subtitle">Daftar tugas yang harus dikerjakan.</p>

            <?php if (isset($_GET['berhasil'])): ?>
                <script>
                    alert('Jawaban berhasil dikirim');
                </script>
            <?php endif; ?>

            <div class="task-grid">

                <?php while($row = mysqli_fetch_assoc($tugas)): ?>

                    <div class="task-card">

                        <div class="task-card-top">
                            <span class="mapel-tag">
                                <?= !empty($row['nama_mapel']) ? htmlspecialchars($row['nama_mapel']) : '-'; ?>
                            </span>
                            <span class="badge progress">
                                <?= htmlspecialchars($row['status']); ?>
                            </span>
                        </div>

                        <h3><?= htmlspecialchars($row['nama_tugas']); ?></h3>

                        <div class="task-info">
                            <p>
                                <i class="fa-regular fa-clock"></i>
                                <?= date('d M Y', strtotime($row['deadline'])); ?>
                            </p>
                        </div>

                        <a href="upload_tugas.php?id=<?= $row['id']; ?>" class="btn-primary">
                            <i class="fa-solid fa-upload"></i>
                            Upload Jawaban
                        </a>

                    </div>

                <?php endwhile; ?>

            </div>

        </div>

    </div>

</div>

</body>
</html>
