<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mapel</title>
    <link rel="stylesheet" href="../assets/css/guru.css">
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <div class="page-header">
                <div>
                    <h1 class="page-title">Mapel</h1>
                    <p class="page-subtitle">Kelola daftar mata pelajaran.</p>
                </div>

                <button type="button" class="btn-primary" id="btnTambahMapel">
                    <i class="fas fa-plus"></i>
                    Tambah
                </button>
            </div>

            <div class="table-box">

                <table>
                    <thead>
                        <tr>
                            <th>Nama Mapel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($mapelList as $row) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_mapel']); ?></td>
                        <td>
                            <button
                                type="button"
                                class="btn-edit btn-edit-mapel-trigger"
                                data-id="<?= $row['id']; ?>"
                                data-nama-mapel="<?= htmlspecialchars($row['nama_mapel']); ?>"
                            >
                                Edit
                            </button>

                            <a href="mapel.php?hapus=<?= $row['id']; ?>"
                            class="btn-delete"
                            onclick="return confirm('Yakin ingin menghapus mapel ini?')">
                            Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

</div>

<!-- MODAL TAMBAH MAPEL -->
<div class="modal-overlay" id="modalTambahMapel">
    <div class="modal-box">

        <div class="modal-header">
            <span class="modal-title">Tambah Mapel</span>
            <button type="button" class="modal-close" data-close-modal="modalTambahMapel">&times;</button>
        </div>

        <div class="form-box">
            <form method="POST">

                <div class="form-group">
                    <label>Nama Mapel</label>
                    <input type="text" name="nama_mapel" class="form-input" required>
                </div>

                <button type="submit" name="simpan_mapel" class="submit-btn">
                    Simpan Mapel
                </button>

            </form>
        </div>

    </div>
</div>

<!-- MODAL EDIT MAPEL -->
<div class="modal-overlay" id="modalEditMapel">
    <div class="modal-box">

        <div class="modal-header">
            <span class="modal-title">Edit Mapel</span>
            <button type="button" class="modal-close" data-close-modal="modalEditMapel">&times;</button>
        </div>

        <div class="form-box">
            <form method="POST">

                <input type="hidden" name="id" id="edit_mapel_id_field">

                <div class="form-group">
                    <label>Nama Mapel</label>
                    <input type="text" name="nama_mapel" id="edit_nama_mapel" class="form-input" required>
                </div>

                <button type="submit" name="update_mapel" class="submit-btn">
                    Update Mapel
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

    document.getElementById('btnTambahMapel').addEventListener('click', function () {
        openModal('modalTambahMapel');
    });

    document.querySelectorAll('.btn-edit-mapel-trigger').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('edit_mapel_id_field').value = btn.dataset.id;
            document.getElementById('edit_nama_mapel').value = btn.dataset.namaMapel;
            openModal('modalEditMapel');
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