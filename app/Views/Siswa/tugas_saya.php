<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Saya</title>

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
            <h1>Tugas Saya</h1>
            <p>Daftar tugas yang harus dikerjakan.</p>
        </div>

        <?php if (isset($_GET['berhasil'])): ?>
            <script>
                alert('Jawaban berhasil dikirim');
            </script>
        <?php endif; ?>

        <div class="task-grid">

            <?php while($row = mysqli_fetch_assoc($tugas)): ?>

                <div class="task-card">

                    <div class="task-card-top">

                        <span class="mapel">
                            <?= !empty($row['nama_mapel']) ? htmlspecialchars($row['nama_mapel']) : '-'; ?>
                        </span>

                        <span class="status progress">
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

                    <div class="task-action">

                        <a href="upload_tugas.php?id=<?= $row['id']; ?>"
                        class="btn-upload">

                            Upload Jawaban

                        </a>

                    </div>

                </div>

            <?php endwhile; ?>
            </div>

        </div>

    </main>

</div>

</body>
</html>
