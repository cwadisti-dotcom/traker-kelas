<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Materi</title>
    <link rel="stylesheet" href="../assets/css/guru.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <div class="page-header">
                <div>
                    <h1 class="page-title">Materi</h1>
                    <p class="page-subtitle">Kelola materi pembelajaran untuk siswa.</p>
                </div>

                <button type="button" class="btn-primary" id="btnTambahMateri">
                    <i class="fas fa-plus"></i>
                    Tambah
                </button>
            </div>

            <?php if(!empty($error)): ?>
                <div class="alert-error"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="table-box">
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Mapel</th>
                            <th>File</th>
                            <th>Diupload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($materi)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['judul']); ?></td>
                        <td><?= !empty($row['nama_mapel']) ? htmlspecialchars($row['nama_mapel']) : '-'; ?></td>
                        <td>
                            <?php if(!empty($row['file_materi'])): ?>
                                <a href="../uploads/materi/<?= htmlspecialchars($row['file_materi']); ?>" target="_blank">Lihat File</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <button
                                type="button"
                                class="btn-edit btn-edit-materi-trigger"
                                data-id="<?= $row['id']; ?>"
                                data-judul="<?= htmlspecialchars($row['judul']); ?>"
                                data-deskripsi="<?= htmlspecialchars($row['deskripsi']); ?>"
                                data-mapel-id="<?= $row['mapel_id']; ?>"
                            >
                                Edit
                            </button>

                            <a href="materi.php?hapus=<?= $row['id']; ?>"
                            class="btn-delete"
                            onclick="return confirm('Yakin ingin menghapus materi ini?')">
                            Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

<!-- MODAL TAMBAH MATERI -->
<div class="modal-overlay" id="modalTambahMateri">
    <div class="modal-box">

        <div class="modal-header">
            <span class="modal-title">Tambah Materi</span>
            <button type="button" class="modal-close" data-close-modal="modalTambahMateri">&times;</button>
        </div>

        <div class="form-box">
            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Mapel</label>
                    <select name="mapel_id" class="form-input" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php foreach($mapelList as $m): ?>
                            <option value="<?= $m['id']; ?>"><?= htmlspecialchars($m['nama_mapel']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-textarea" required></textarea>
                </div>

                <div class="form-group">
                    <label>File Materi</label>
                    <input type="file" name="file_materi" accept=".pdf,.jpg,.jpeg,.png,.ppt,.pptx,.doc,.docx" class="form-file" required>
                    <small>Format: PDF, JPG, PNG, PPT, DOCX</small>
                </div>

                <button type="submit" name="simpan_materi" class="submit-btn">
                    Simpan Materi
                </button>

            </form>
        </div>

    </div>
</div>

<!-- MODAL EDIT MATERI -->
<div class="modal-overlay" id="modalEditMateri">
    <div class="modal-box">

        <div class="modal-header">
            <span class="modal-title">Edit Materi</span>
            <button type="button" class="modal-close" data-close-modal="modalEditMateri">&times;</button>
        </div>

        <div class="form-box">
            <form method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" id="edit_materi_id_field">

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" id="edit_judul" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Mapel</label>
                    <select name="mapel_id" id="edit_mapel_id_materi" class="form-input" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php foreach($mapelList as $m): ?>
                            <option value="<?= $m['id']; ?>"><?= htmlspecialchars($m['nama_mapel']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi_materi" class="form-textarea" required></textarea>
                </div>

                <div class="form-group">
                    <label>Ganti File (opsional)</label>
                    <input type="file" name="file_materi" accept=".pdf,.jpg,.jpeg,.png,.ppt,.pptx,.doc,.docx" class="form-file">
                    <small>Kosongkan jika tidak ingin mengganti file</small>
                </div>

                <button type="submit" name="update_materi" class="submit-btn">
                    Update Materi
                </button>

            </form>
        </div>

    </div>
</div>

<script>
(function () {
    function openModal(id) {
        document.getElementById(id).classList.add('is-open');
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('is-open');
    }

    document.getElementById('btnTambahMateri').addEventListener('click', function () {
        openModal('modalTambahMateri');
    });

    document.querySelectorAll('.btn-edit-materi-trigger').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('edit_materi_id_field').value = btn.dataset.id;
            document.getElementById('edit_judul').value = btn.dataset.judul;
            document.getElementById('edit_deskripsi_materi').value = btn.dataset.deskripsi;
            document.getElementById('edit_mapel_id_materi').value = btn.dataset.mapelId;
            openModal('modalEditMateri');
        });
    });

    document.querySelectorAll('[data-close-modal]').forEach(function (el) {
        el.addEventListener('click', function () {
            closeModal(el.dataset.closeModal);
        });
    });

    document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.classList.remove('is-open');
            }
        });
    });
})();
</script>

</body>
</html>