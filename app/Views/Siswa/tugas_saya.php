<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumpulan</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body class="theme-siswa">

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <h1 class="page-title">Pengumpulan</h1>
            <p class="page-subtitle">Daftar tugas dan materi dari guru.</p>

            <?php if (isset($_GET['berhasil'])): ?>
                <script>
                    alert('Jawaban berhasil dikirim');
                </script>
            <?php endif; ?>

            <div class="siswa-tabs">
                <button type="button" class="siswa-tab is-active" data-tab-target="panel-tugas">
                    <i class="fa-solid fa-clipboard"></i>
                    Tugas
                </button>
                <button type="button" class="siswa-tab" data-tab-target="panel-materi">
                    <i class="fa-solid fa-book-open"></i>
                    Materi
                </button>
            </div>

            <!-- TAB: TUGAS -->
            <div class="tab-panel" id="panel-tugas">

                <div class="task-list">

                    <?php $ada_tugas = false; ?>
                    <?php while($row = mysqli_fetch_assoc($tugas)): $ada_tugas = true; ?>

                        <a href="detail_tugas.php?id=<?= $row['id']; ?>" class="task-row">

                            <div class="task-row-main">
                                <div class="task-row-icon">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                </div>

                                <div class="task-row-text">
                                    <h3><?= htmlspecialchars($row['nama_tugas']); ?></h3>
                                    <div class="task-row-top">
                                        <span class="mapel-tag">
                                            <?= !empty($row['nama_mapel']) ? htmlspecialchars($row['nama_mapel']) : '-'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="task-row-side">
                                <div class="task-info">
                                    <p>
                                        <i class="fa-regular fa-clock"></i>
                                        <?= date('d M Y', strtotime($row['deadline'])); ?>
                                    </p>
                                </div>

                                <?php
                                    $status_siswa = $row['status_siswa'];
                                    $badge_class = 'progress'; // default: Belum Dikerjakan

                                    if ($status_siswa === 'Belum Dinilai') {
                                        $badge_class = 'pending';
                                    } elseif ($status_siswa === 'Sudah Dinilai') {
                                        $badge_class = 'success';
                                    }
                                ?>
                                <span class="badge <?= $badge_class; ?>">
                                    <?= htmlspecialchars($status_siswa); ?>
                                </span>

                                <i class="fa-solid fa-chevron-right task-row-arrow"></i>
                            </div>

                        </a>

                    <?php endwhile; ?>

                    <?php if (!$ada_tugas): ?>
                        <div class="empty-state">Belum ada tugas.</div>
                    <?php endif; ?>

                </div>

            </div>

            <!-- TAB: MATERI -->
            <div class="tab-panel" id="panel-materi" hidden>

                <div class="materi-list">

                    <?php $ada_materi = false; ?>
                    <?php while($row = mysqli_fetch_assoc($materi)): $ada_materi = true; ?>

                        <a href="detail_materi.php?id=<?= $row['id']; ?>" class="materi-row">

                            <div class="materi-row-main">
                                <div class="materi-row-icon">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>

                                <div class="materi-row-text">
                                    <h3><?= htmlspecialchars($row['judul']); ?></h3>
                                    <div class="materi-row-meta">
                                        <span class="mapel-tag">
                                            <?= !empty($row['nama_mapel']) ? htmlspecialchars($row['nama_mapel']) : '-'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="task-row-side">
                                <span class="materi-row-date">
                                    <?= date('d M Y', strtotime($row['created_at'])); ?>
                                </span>

                                <i class="fa-solid fa-chevron-right task-row-arrow"></i>
                            </div>

                        </a>

                    <?php endwhile; ?>

                    <?php if (!$ada_materi): ?>
                        <div class="empty-state">Belum ada materi.</div>
                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
(function () {
    var tabs   = document.querySelectorAll('.siswa-tab');
    var panels = document.querySelectorAll('.tab-panel');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var targetId = tab.dataset.tabTarget;

            tabs.forEach(function (t) { t.classList.remove('is-active'); });
            tab.classList.add('is-active');

            panels.forEach(function (panel) {
                panel.hidden = panel.id !== targetId;
            });
        });
    });
})();
</script>

</body>
</html>