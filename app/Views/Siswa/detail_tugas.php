<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Tugas</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>

<body class="theme-siswa">

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <?php if (!$tugas): ?>

                <a href="tugas_saya.php" class="detail-back">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali ke tugas saya
                </a>

                <div class="detail-not-found">
                    Tugas tidak ditemukan.
                </div>

            <?php else: ?>

                <!-- KEMBALI -->
                <a href="tugas_saya.php" class="detail-back">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali ke tugas saya
                </a>


                <!-- LAYOUT DETAIL -->
                <div class="detail-layout">

                    <!-- =========================
                         KOLOM KIRI
                    ========================== -->
                    <div class="detail-left">


                        <!-- JUDUL + DESKRIPSI -->
                        <div class="detail-task-card">

                            <h1>
                                <?= htmlspecialchars($tugas['nama_tugas']); ?>
                            </h1>

                            <p>
                                <?= nl2br(
                                    htmlspecialchars(
                                        $tugas['deskripsi'] ?? '-'
                                    )
                                ); ?>
                            </p>

                        </div>


                        <!-- MATERI TERKAIT -->
                        <div class="detail-card detail-material-card">

                            <h2>Materi terkait</h2>

                            <div class="material-file">

                                <i class="fa-regular fa-file-lines"></i>

                                <span>
                                    Materi terkait tugas
                                </span>

                            </div>

                        </div>


                        <!-- KUMPULKAN JAWABAN -->
                        <div class="detail-card detail-submit-card">

                            <h2>Kumpulkan jawaban</h2>

                            <p class="submit-info">
                                Format: PDF maksimal 5MB.
                            </p>

                            <form
                                action="upload_tugas.php?id=<?= $tugas['id']; ?>"
                                method="POST"
                                enctype="multipart/form-data"
                            >

                                <input
                                    type="file"
                                    name="file"
                                    class="detail-file-input"
                                    accept=".pdf"
                                    required
                                >

                                <button
                                    type="submit"
                                    name="upload"
                                    class="detail-upload-button"
                                >
                                    <i class="fa-solid fa-arrow-up"></i>
                                    Upload jawaban
                                </button>

                            </form>

                        </div>

                    </div>


                    <!-- =========================
                         KOLOM KANAN
                    ========================== -->
                    <div class="detail-right">

                        <div class="detail-info-card">

                            <h2>Informasi</h2>


                            <div class="info-item">

                                <span class="info-label">
                                    Mapel
                                </span>

                                <span class="info-value">
                                    <?= !empty($tugas['nama_mapel'])
                                        ? htmlspecialchars($tugas['nama_mapel'])
                                        : '-'; ?>
                                </span>

                            </div>


                            <div class="info-item">

                                <span class="info-label">
                                    Deadline
                                </span>

                                <span class="info-value">
                                    <?= date(
                                        'd M Y',
                                        strtotime($tugas['deadline'])
                                    ); ?>
                                </span>

                            </div>


                            <div class="info-item">

                                <span class="info-label">
                                    Status
                                </span>

                                <span class="info-status">
                                    <?= htmlspecialchars($tugas['status']); ?>
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>