<?php

include '../config/koneksi.php';

/* =========================================================
   SIMPAN / UPDATE NILAI
========================================================= */

if (isset($_POST['simpan_nilai'])) {

    $pengumpulan_id = (int) ($_POST['pengumpulan_id'] ?? 0);
    $nilai = (int) ($_POST['nilai'] ?? 0);

    if ($pengumpulan_id <= 0) {
        die('ID pengumpulan tugas tidak valid.');
    }

    if ($nilai < 0 || $nilai > 100) {
        die('Nilai harus antara 0 sampai 100.');
    }

    $query_simpan = mysqli_query(
        $koneksi,
        "UPDATE pengumpulan_tugas
         SET nilai = '$nilai',
             status = 'Sudah Dinilai'
         WHERE id = '$pengumpulan_id'"
    );

    if ($query_simpan) {

        echo "
        <script>
            alert('Nilai berhasil disimpan!');
            window.location.href = 'laporan.php';
        </script>
        ";

        exit;

    } else {

        die(
            'Gagal menyimpan nilai: ' .
            mysqli_error($koneksi)
        );
    }
}


/* =========================================================
   FILTER
========================================================= */

$filter_mapel = $_GET['mapel_id'] ?? '';
$filter_status = $_GET['status'] ?? '';
$filter_awal = $_GET['tanggal_awal'] ?? '';
$filter_akhir = $_GET['tanggal_akhir'] ?? '';


/* =========================================================
   DATA MAPEL UNTUK FILTER
========================================================= */

$query_mapel = mysqli_query(
    $koneksi,
    "SELECT id, nama_mapel
     FROM mapel
     ORDER BY nama_mapel ASC"
);

$mapelList = [];

if ($query_mapel) {

    while ($m = mysqli_fetch_assoc($query_mapel)) {
        $mapelList[] = $m;
    }
}


/* =========================================================
   QUERY REKAP NILAI
========================================================= */

$sql_rekap = "
    SELECT
        pengumpulan_tugas.id AS id,
        users.username AS nama_siswa,
        mapel.nama_mapel AS nama_mapel,
        tugas.nama_tugas AS nama_tugas,
        pengumpulan_tugas.nilai AS nilai,
        pengumpulan_tugas.status AS status,
        pengumpulan_tugas.tanggal_upload AS tanggal_upload

    FROM pengumpulan_tugas

    INNER JOIN users
        ON pengumpulan_tugas.siswa_id = users.id

    INNER JOIN tugas
        ON pengumpulan_tugas.tugas_id = tugas.id

    INNER JOIN mapel
        ON tugas.mapel_id = mapel.id

    WHERE 1=1
";


/* =========================================================
   FILTER MAPEL
========================================================= */

if ($filter_mapel !== '') {

    $mapel_id = (int) $filter_mapel;

    $sql_rekap .= "
        AND tugas.mapel_id = '$mapel_id'
    ";
}


/* =========================================================
   FILTER STATUS
========================================================= */

if ($filter_status !== '') {

    $status = mysqli_real_escape_string(
        $koneksi,
        $filter_status
    );

    $sql_rekap .= "
        AND pengumpulan_tugas.status = '$status'
    ";
}


/* =========================================================
   FILTER TANGGAL AWAL
========================================================= */

if ($filter_awal !== '') {

    $tanggal_awal = mysqli_real_escape_string(
        $koneksi,
        $filter_awal
    );

    $sql_rekap .= "
        AND DATE(pengumpulan_tugas.tanggal_upload)
        >= '$tanggal_awal'
    ";
}


/* =========================================================
   FILTER TANGGAL AKHIR
========================================================= */

if ($filter_akhir !== '') {

    $tanggal_akhir = mysqli_real_escape_string(
        $koneksi,
        $filter_akhir
    );

    $sql_rekap .= "
        AND DATE(pengumpulan_tugas.tanggal_upload)
        <= '$tanggal_akhir'
    ";
}


/* =========================================================
   URUTKAN DATA
========================================================= */

$sql_rekap .= "
    ORDER BY pengumpulan_tugas.tanggal_upload DESC
";


/* =========================================================
   JALANKAN QUERY
========================================================= */

$rekap = mysqli_query(
    $koneksi,
    $sql_rekap
);

if (!$rekap) {

    die(
        'Query laporan gagal: ' .
        mysqli_error($koneksi)
    );
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Laporan Rekap Nilai</title>

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

    <style>

        /* ==============================
           FILTER LAPORAN
        ============================== */

        .filter-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            margin: 20px 0;
        }

        .filter-bar select,
        .filter-bar input[type="date"] {
            padding: 10px 12px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            font-family: var(--font-primary);
            font-size: var(--text-xs);
            background: var(--color-surface);
            color: var(--color-text);
            outline: none;
            cursor: pointer;
        }

        .filter-bar select:focus,
        .filter-bar input[type="date"]:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 2px rgba(204, 136, 0, 0.18);
        }

        .filter-bar input[type="date"] {
            cursor: text;
        }

.filter-separator {
    font-size: var(--text-xs);
    color: var(--color-text-muted, #888);
    padding: 0 2px;
}
        /* ==============================
           BUTTON
        ============================== */

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            padding: 10px 14px;

            border: none;
            border-radius: var(--radius-sm);

            font-family: var(--font-primary);
            font-size: var(--text-xs);
            font-weight: 600;

            text-decoration: none;
            cursor: pointer;

            transition: all var(--transition-fast);
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }


        /* Filter */

        .btn-filter {
            background: var(--color-primary);
            color: var(--color-surface-inverse);
        }

        .btn-filter:hover {
            background: var(--color-primary-hover);
        }


        /* Reset */

        .btn-reset {
            background: var(--color-surface);
            color: var(--color-text);
            border: 1px solid var(--color-border);
        }

        .btn-reset:hover {
            background: var(--color-surface-muted);
        }


        /* Excel */

        .btn-excel {
            background: var(--color-success);
            color: #fff;
        }

        .btn-excel:hover {
            background: #15803d;
        }


        /* PDF */

        .btn-pdf {
            background: var(--color-danger);
            color: #fff;
        }

        .btn-pdf:hover {
            background: #b91c1c;
        }


        /* ==============================
           STATUS
        ============================== */

        .status-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: var(--radius-sm);
            font-size: 10px;
            font-weight: 600;
        }

        .status-sudah {
            background: var(--color-success-tint);
            color: var(--color-success);
        }

        .status-belum {
            background: var(--color-warning-tint);
            color: var(--color-warning);
        }


        /* ==============================
           NILAI
        ============================== */

        .nilai-badge {
            font-family: var(--font-mono);
            font-weight: 700;
        }


        /* ==============================
           TOMBOL AKSI
        ============================== */

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;

            padding: 7px 11px;

            border: none;
            border-radius: var(--radius-sm);

            font-family: var(--font-primary);
            font-size: var(--text-xs);
            font-weight: 600;

            cursor: pointer;

            transition: all var(--transition-fast);
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        .edit-btn {
            background: var(--color-primary);
            color: #fff;
        }

        .edit-btn:hover {
            background: var(--color-primary-hover);
        }


        /* ==============================
           RESPONSIVE
        ============================== */

        @media (max-width: 900px) {

            .filter-bar {
                align-items: stretch;
            }

            .filter-bar select,
            .filter-bar input[type="date"],
            .btn-action {
                width: 100%;
            }

            body.theme-guru .table-box {
                overflow-x: auto;
            }

            body.theme-guru table {
                min-width: 800px;
            }

        }

    </style>

</head>


<body class="theme-guru">

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>


    <div class="main-content">

        <div class="content-box">


            <!-- ==============================
                 HEADER
            ============================== -->

            <h1 class="page-title">
                Laporan Rekap Nilai
            </h1>

            <p class="page-subtitle">
                Lihat dan unduh rekap nilai siswa dalam format Excel atau PDF.
            </p>


            <!-- ==============================
                 FILTER
            ============================== -->

            <form
                method="GET"
                class="filter-bar"
            >

                <!-- MAPEL -->

                <select name="mapel_id">

                    <option value="">
                        Semua Mapel
                    </option>

                    <?php foreach ($mapelList as $m): ?>

                        <option
                            value="<?= (int) $m['id'] ?>"
                            <?= $filter_mapel == $m['id'] ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($m['nama_mapel']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>


                <!-- STATUS -->

                <select name="status">

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="Sudah Dinilai"
                        <?= $filter_status === 'Sudah Dinilai' ? 'selected' : '' ?>
                    >
                        Sudah Dinilai
                    </option>

                    <option
                        value="Belum Dinilai"
                        <?= $filter_status === 'Belum Dinilai' ? 'selected' : '' ?>
                    >
                        Belum Dinilai
                    </option>

                </select>


                <!-- TANGGAL AWAL -->

                <input
                    type="date"
                    name="tanggal_awal"
                    value="<?= htmlspecialchars($filter_awal) ?>"
                >
<span class="filter-separator">s/d</span>

                <!-- TANGGAL AKHIR -->

                <input
                    type="date"
                    name="tanggal_akhir"
                    value="<?= htmlspecialchars($filter_akhir) ?>"
                >


                <!-- FILTER -->

                <button
                    type="submit"
                    class="btn-action btn-filter"
                >
                    <i class="fa-solid fa-filter"></i>
                    Filter
                </button>


                <!-- RESET -->

                <a
                    href="laporan.php"
                    class="btn-action btn-reset"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>


                <!-- EXCEL -->

                <a
                    href="laporan_export_excel.php?<?= http_build_query($_GET) ?>"
                    class="btn-action btn-excel"
                >
                    <i class="fa-solid fa-file-excel"></i>
                    Export Excel
                </a>


                <!-- PDF -->

                <a
                    href="laporan_export_pdf.php?<?= http_build_query($_GET) ?>"
                    class="btn-action btn-pdf"
                >
                    <i class="fa-solid fa-file-pdf"></i>
                    Export PDF
                </a>

            </form>


            <!-- ==============================
                 TABLE LAPORAN
            ============================== -->

            <div class="table-box">

                <table>

                    <thead>

                        <tr>

                            <th>Nama Siswa</th>

                            <th>Mapel</th>

                            <th>Nama Tugas</th>

                            <th>Nilai</th>

                            <th>Status</th>

                            <th>Tanggal Upload</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (mysqli_num_rows($rekap) > 0): ?>


                            <?php while ($row = mysqli_fetch_assoc($rekap)): ?>

                                <tr>


                                    <!-- NAMA SISWA -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $row['nama_siswa']
                                        ) ?>

                                    </td>


                                    <!-- MAPEL -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $row['nama_mapel']
                                        ) ?>

                                    </td>


                                    <!-- NAMA TUGAS -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $row['nama_tugas']
                                        ) ?>

                                    </td>


                                    <!-- NILAI -->

                                    <td>

                                        <span class="nilai-badge">

                                            <?= htmlspecialchars(
                                                $row['nilai']
                                            ) ?>

                                        </span>

                                    </td>


                                    <!-- STATUS -->

                                    <td>

                                        <?php if (
                                            $row['status'] === 'Sudah Dinilai'
                                        ): ?>

                                            <span
                                                class="status-badge status-sudah"
                                            >
                                                Sudah Dinilai
                                            </span>

                                        <?php else: ?>

                                            <span
                                                class="status-badge status-belum"
                                            >
                                                Belum Dinilai
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- TANGGAL -->

                                    <td>

                                        <?= date(
                                            'd M Y',
                                            strtotime(
                                                $row['tanggal_upload']
                                            )
                                        ) ?>

                                    </td>


<!-- AKSI -->

<td>

    <?php if ($row['status'] === 'Sudah Dinilai'): ?>

        <button
            type="button"
            class="action-btn edit-btn"
            onclick='openNilaiModal(
                <?= (int) $row['id'] ?>,
                <?= (int) $row['nilai'] ?>
            )'
        >
            <i class="fa-solid fa-pen"></i>
            Edit
        </button>

    <?php else: ?>

        <button
            type="button"
            class="action-btn edit-btn"
            onclick='openNilaiModal(
                <?= (int) $row['id'] ?>,
                ""
            )'
        >
            <i class="fa-solid fa-star"></i>
            Nilai
        </button>

    <?php endif; ?>

</td>


                                </tr>

                            <?php endwhile; ?>


                        <?php else: ?>


                            <tr>

                                <td
                                    colspan="7"
                                    style="text-align:center; padding:30px;"
                                >
                                    Belum ada data laporan.
                                </td>

                            </tr>


                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<!-- =====================================================
     MODAL NILAI
===================================================== -->

<div
    class="modal-overlay"
    id="nilaiModal"
>

    <div class="modal-box">

        <!-- HEADER MODAL -->
        <div class="modal-header">

            <h2
                class="modal-title"
                id="modalTitle"
            >
                Input Nilai
            </h2>

            <button
                type="button"
                class="modal-close"
                onclick="closeNilaiModal()"
            >
                &times;
            </button>

        </div>


        <!-- FORM -->
        <form method="POST">

            <!-- ID PENGUMPULAN -->
            <input
                type="hidden"
                name="pengumpulan_id"
                id="pengumpulan_id"
            >


            <!-- NILAI -->
            <div class="form-group">

                <label>
                    Nilai
                </label>

                <input
                    type="number"
                    name="nilai"
                    id="modal_nilai"
                    class="form-input"
                    min="0"
                    max="100"
                    required
                >

            </div>


            <!-- SUBMIT -->
            <button
                type="submit"
                name="simpan_nilai"
                class="submit-btn"
                id="modalSubmit"
            >
                <i class="fa-solid fa-check"></i>
                Simpan Nilai
            </button>

        </form>

    </div>

</div>


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>

/* =====================================================
   BUKA MODAL NILAI
===================================================== */

function openNilaiModal(id, nilai) {

    // Simpan ID pengumpulan
    document.getElementById('pengumpulan_id').value = id;

    // Masukkan nilai ke input
    document.getElementById('modal_nilai').value = nilai;

    // Tampilkan modal
    document.getElementById('nilaiModal').classList.add('is-open');


    // Jika belum ada nilai
    if (nilai === '') {

        document.getElementById('modalTitle').innerText =
            'Input Nilai';

        document.getElementById('modalSubmit').innerHTML =
            '<i class="fa-solid fa-check"></i> Simpan Nilai';

    }

    // Jika sudah ada nilai
    else {

        document.getElementById('modalTitle').innerText =
            'Edit Nilai';

        document.getElementById('modalSubmit').innerHTML =
            '<i class="fa-solid fa-check"></i> Simpan Perubahan';

    }

}


/* =====================================================
   TUTUP MODAL
===================================================== */

function closeNilaiModal() {

    document
        .getElementById('nilaiModal')
        .classList.remove('is-open');

}


/* =====================================================
   KLIK AREA GELAP UNTUK MENUTUP MODAL
===================================================== */

document
    .getElementById('nilaiModal')
    .addEventListener(
        'click',
        function(e) {

            if (e.target === this) {

                closeNilaiModal();

            }

        }
    );

</script>



</body>

</html>