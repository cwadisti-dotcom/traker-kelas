<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Materi</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>

<body class="theme-siswa">

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <div class="detail-page">

                <a href="tugas_saya.php" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali ke pengumpulan
                </a>

                <?php if (!$materi): ?>

                    <div class="empty-state">Materi tidak ditemukan.</div>

                <?php else: ?>

                    <!-- HEADER -->
                    <div class="detail-header">
                        <h1 class="detail-title"><?= htmlspecialchars($materi['judul']); ?></h1>
                    </div>

                    <!-- DESKRIPSI -->
                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fa-regular fa-file-lines"></i>
                            Deskripsi
                        </div>
                        <p class="detail-description">
                            <?= nl2br(htmlspecialchars($materi['deskripsi'] ?? '-')); ?>
                        </p>
                    </div>

                    <!-- INFORMASI -->
                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fa-regular fa-clock"></i>
                            Informasi
                        </div>
                        <div class="detail-info-grid cols-2">
                            <div class="detail-info-item">
                                <span class="detail-info-label">Mapel</span>
                                <span class="detail-info-value">
                                    <?= !empty($materi['nama_mapel']) ? htmlspecialchars($materi['nama_mapel']) : '-'; ?>
                                </span>
                            </div>
                            <div class="detail-info-item">
                                <span class="detail-info-label">Diupload</span>
                                <span class="detail-info-value">
                                    <?= date('d M Y', strtotime($materi['created_at'])); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- FILE MATERI -->
                    <?php if (!empty($materi['file_materi'])): ?>
                        <div class="detail-section">
                            <div class="detail-section-title">
                                <i class="fa-regular fa-folder-open"></i>
                                File Materi
                            </div>
                            <div class="detail-file">
                                <div class="detail-file-info">
                                    <div class="detail-file-icon">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </div>
                                    <span class="detail-file-name"><?= htmlspecialchars($materi['file_materi']); ?></span>
                                </div>
                                <a href="../uploads/materi/<?= htmlspecialchars($materi['file_materi']); ?>" target="_blank" class="detail-file-button">
                                    <i class="fa-solid fa-up-right-from-square"></i>
                                    Buka File
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

</body>
</html>