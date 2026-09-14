<?php ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Tugas</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
.pdf-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(27,18,11,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.2s ease;
    z-index: 2000;
}

.pdf-modal-overlay.is-open {
    opacity: 1;
    visibility: visible;
}

.pdf-modal-box {
    width: 90vw;
    height: 90vh;
    max-width: 1000px;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transform: translateY(10px);
    transition: transform 0.2s ease;
}

.pdf-modal-overlay.is-open .pdf-modal-box {
    transform: translateY(0);
}

.pdf-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    background: #1B120B;
    color: #FBF6EC;
}

.pdf-modal-title {
    font-weight: 700;
    font-size: 14px;
}

.pdf-modal-close {
    background: transparent;
    border: none;
    color: #FBF6EC;
    font-size: 22px;
    cursor: pointer;
    line-height: 1;
}

.pdf-modal-close:hover {
    color: #CC8800;
}

.pdf-modal-frame {
    flex: 1;
    border: none;
    width: 100%;
}
</style>
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

                <?php if (!$tugas): ?>

                    <div class="empty-state">Tugas tidak ditemukan.</div>

                <?php else: ?>

                    <?php
                        $status_saat_ini = $pengumpulan['status'] ?? 'Belum Dikerjakan';
                    ?>

                    <!-- HEADER -->
                    <div class="detail-header">
                        <h1 class="detail-title"><?= htmlspecialchars($tugas['nama_tugas']); ?></h1>
                    </div>

                    <!-- DESKRIPSI -->
                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fa-regular fa-file-lines"></i>
                            Deskripsi Tugas
                        </div>
                        <p class="detail-description">
                            <?= nl2br(htmlspecialchars($tugas['deskripsi'] ?? '-')); ?>
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
                                    <?= !empty($tugas['nama_mapel']) ? htmlspecialchars($tugas['nama_mapel']) : '-'; ?>
                                </span>
                            </div>
                            <div class="detail-info-item">
                                <span class="detail-info-label">Deadline</span>
                                <span class="detail-info-value">
                                    <?= date('d M Y', strtotime($tugas['deadline'])); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- FILE TUGAS -->
                    <?php if (!empty($tugas['file_pdf'])): ?>
                        <div class="detail-section">
                            <div class="detail-section-title">
                                <i class="fa-regular fa-folder-open"></i>
                                File Tugas
                            </div>
                            <div class="detail-file">
                                <div class="detail-file-info">
                                    <div class="detail-file-icon">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </div>
                                    <span class="detail-file-name"><?= htmlspecialchars($tugas['file_pdf']); ?></span>
                                </div>
                             <a href="#" onclick="bukaPdfModal('../uploads/tugas/<?= rawurlencode($tugas['file_pdf']); ?>'); return false;" class="detail-file-button">
    <i class="fa-solid fa-up-right-from-square"></i>
    Buka File
</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- KUMPULKAN JAWABAN / HASIL PENILAIAN -->
                    <?php if ($pengumpulan): ?>

                        <div class="detail-section">
                            <div class="detail-section-title">
                                <i class="fa-solid <?= $status_saat_ini === 'Sudah Dinilai' ? 'fa-clipboard-check' : 'fa-paper-plane'; ?>"></i>
                                <?= $status_saat_ini === 'Sudah Dinilai' ? 'Hasil Penilaian Tugas' : 'Jawaban Terkirim'; ?>
                            </div>

                            <?php if (!empty($pengumpulan['jawaban'])): ?>
                                <p class="detail-description"><?= nl2br(htmlspecialchars($pengumpulan['jawaban'])); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($pengumpulan['file_jawaban'])): ?>
                                <div class="detail-file">
                                    <div class="detail-file-info">
                                        <div class="detail-file-icon">
                                            <i class="fa-regular fa-file-lines"></i>
                                        </div>
                                        <span class="detail-file-name"><?= htmlspecialchars($pengumpulan['file_jawaban']); ?></span>
                                    </div>
                                  <a href="#" onclick="bukaPdfModal('../uploads/jawaban/<?= rawurlencode($pengumpulan['file_jawaban']); ?>'); return false;" class="detail-file-button">
    <i class="fa-solid fa-up-right-from-square"></i>
    Lihat File
</a>
                                </div>
                            <?php endif; ?>

                            <?php if ($status_saat_ini === 'Sudah Dinilai'): ?>
                                <div class="detail-info-grid cols-2" style="margin-top:16px;">
                                    <div class="detail-info-item">
                                        <span class="detail-info-label">Status</span>
                                        <span class="detail-info-value">Sudah Dinilai</span>
                                    </div>
                                    <div class="detail-info-item">
                                        <span class="detail-info-label">Nilai</span>
                                        <span class="detail-info-value"><?= (int) $pengumpulan['nilai']; ?></span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="detail-description" style="margin-top:12px; color:var(--color-text-muted);">
                                    Menunggu penilaian guru.
                                </p>
                            <?php endif; ?>
                        </div>

                    <?php else: ?>

                        <div class="detail-section">
                            <div class="detail-section-title">
                                <i class="fa-solid fa-paper-plane"></i>
                                Kumpulkan Jawaban
                            </div>

                            <p class="detail-description" style="margin-bottom:16px;">
                                Format: PDF maksimal 5MB.
                            </p>

                            <?php if (($_GET['error'] ?? '') === 'format_tidak_didukung'): ?>
                                <div class="alert-error" style="margin-bottom:16px;">
                                    Format file tidak didukung. Hanya file PDF yang diperbolehkan.
                                </div>
                            <?php endif; ?>

                            <form
                                action="upload_tugas.php?id=<?= $tugas['id']; ?>"
                                method="POST"
                                enctype="multipart/form-data"
                            >
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea
                                        name="catatan"
                                        class="form-textarea"
                                        placeholder="Tulis jawabanmu di sini..."
                                    ></textarea>
                                </div>

                                <div class="form-group">
                                    <label>File Jawaban</label>
                                    <input
                                        type="file"
                                        name="file"
                                        class="form-file"
                                        accept=".pdf"
                                        required
                                    >
                                </div>

                                <div class="detail-action">
                                    <button
                                        type="submit"
                                        name="upload"
                                        class="detail-upload-btn"
                                    >
                                        <i class="fa-solid fa-arrow-up"></i>
                                        Upload Jawaban
                                    </button>
                                </div>
                            </form>
                        </div>

                    <?php endif; ?>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>
<!-- MODAL PREVIEW PDF -->
<div class="pdf-modal-overlay" id="pdfModalOverlay">
    <div class="pdf-modal-box">
        <div class="pdf-modal-header">
            <span class="pdf-modal-title">Preview File</span>
            <button type="button" class="pdf-modal-close" onclick="tutupPdfModal()">&times;</button>
        </div>
        <iframe id="pdfModalFrame" src="" class="pdf-modal-frame"></iframe>
    </div>
</div>

<script>
function bukaPdfModal(url) {
    document.getElementById('pdfModalFrame').src = url;
    document.getElementById('pdfModalOverlay').classList.add('is-open');
}

function tutupPdfModal() {
    document.getElementById('pdfModalOverlay').classList.remove('is-open');
    document.getElementById('pdfModalFrame').src = '';
}

document.getElementById('pdfModalOverlay').addEventListener('click', function(e) {
    if (e.target === this) {
        tutupPdfModal();
    }
});
</script>
</body>
</html>