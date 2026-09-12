<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tugas</title>
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
                    <h1 class="page-title">Tugas</h1>
                    <p class="page-subtitle">Kelola tugas yang sudah dibuat untuk siswa.</p>
                </div>

                <button type="button" class="btn-primary" id="btnTambahTugas">
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
                            <th>Nama Tugas</th>
                            <th>Mapel</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($row = mysqli_fetch_assoc($tugas)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_tugas']); ?></td>
                        <td><?= !empty($row['nama_mapel']) ? htmlspecialchars($row['nama_mapel']) : '-'; ?></td>
                        <td><?= date('d M Y', strtotime($row['deadline'])); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td>
                            <!-- Tombol Viewer -->
                            <a href="detail_tugas.php?id=<?= $row['id']; ?>" class="btn-edit" style="background-color: #0284c7; color: white; margin-right: 4px; text-decoration: none; display: inline-block;">
                                Viewer
                            </a>

                            <button
                                type="button"
                                class="btn-edit btn-edit-tugas-trigger"
                                data-id="<?= $row['id']; ?>"
                                data-nama-tugas="<?= htmlspecialchars($row['nama_tugas']); ?>"
                                data-deskripsi="<?= htmlspecialchars($row['deskripsi']); ?>"
                                data-deadline="<?= $row['deadline']; ?>"
                                data-mapel-id="<?= $row['mapel_id']; ?>"
                            >
                                Edit
                            </button>

                            <a href="tugas.php?hapus=<?= $row['id']; ?>"
                            class="btn-delete"
                            onclick="return confirm('Yakin ingin menghapus tugas ini?')">
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

<!-- MODAL TAMBAH TUGAS -->
<div class="modal-overlay" id="modalTambahTugas">
    <div class="modal-box">

        <div class="modal-header">
            <span class="modal-title">Tambah Tugas</span>
            <button type="button" class="modal-close" data-close-modal="modalTambahTugas">&times;</button>
        </div>

        <div class="form-box">
            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Nama Tugas</label>
                    <input type="text" name="nama_tugas" class="form-input" required>
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
                    <label>Deadline</label>
                    <input type="date" name="deadline" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Upload PDF</label>
                    <input type="file" name="file_pdf" accept=".pdf" class="form-file">
                </div>

                <button type="submit" name="simpan" class="submit-btn">
                    Simpan Tugas
                </button>

            </form>
        </div>

    </div>
</div>

<!-- MODAL EDIT TUGAS -->
<div class="modal-overlay" id="modalEditTugas">
    <div class="modal-box">

        <div class="modal-header">
            <span class="modal-title">Edit Tugas</span>
            <button type="button" class="modal-close" data-close-modal="modalEditTugas">&times;</button>
        </div>

        <div class="form-box">
            <form method="POST">

                <input type="hidden" name="id" id="edit_tugas_id_field">

                <div class="form-group">
                    <label>Nama Tugas</label>
                    <input type="text" name="nama_tugas" id="edit_nama_tugas" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Mapel</label>
                    <select name="mapel_id" id="edit_mapel_id" class="form-input" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php foreach($mapelList as $m): ?>
                            <option value="<?= $m['id']; ?>"><?= htmlspecialchars($m['nama_mapel']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" class="form-textarea" required></textarea>
                </div>

                <div class="form-group">
                    <label>Deadline</label>
                    <input type="date" name="deadline" id="edit_deadline" class="form-input" required>
                </div>

                <button type="submit" name="update" class="submit-btn">
                    Update Tugas
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

    document.getElementById('btnTambahTugas').addEventListener('click', function () {
        openModal('modalTambahTugas');
    });

    document.querySelectorAll('.btn-edit-tugas-trigger').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('edit_tugas_id_field').value = btn.dataset.id;
            document.getElementById('edit_nama_tugas').value = btn.dataset.namaTugas;
            document.getElementById('edit_deskripsi').value = btn.dataset.deskripsi;
            document.getElementById('edit_deadline').value = btn.dataset.deadline;
            document.getElementById('edit_mapel_id').value = btn.dataset.mapelId;
            openModal('modalEditTugas');
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