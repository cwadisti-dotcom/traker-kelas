<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Saya</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

                                                        <style>
                                                            .filter-bar {
                                                                display: flex;
                                                                gap: 10px;
                                                                flex-wrap: wrap;
                                                                align-items: center;
                                                                margin: 20px 0;
                                                            }
                                                            .filter-separator {
    font-size: var(--text-xs);
    color: var(--color-text-muted, #888);
    padding: 0 2px;
}
.filter-bar select,
.filter-bar input[type="date"] {
    width: auto !important;
    flex: 0 0 auto;
    min-width: 150px;
    max-width: 170px;
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
                                                            .filter-bar input[type="date"] { cursor: text; }

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
                                                            .btn-action:hover { transform: translateY(-1px); }

                                                            .btn-filter { background: var(--color-primary); color: var(--color-surface-inverse); }
                                                            .btn-filter:hover { background: var(--color-primary-hover); }

                                                            .btn-reset { background: var(--color-surface); color: var(--color-text); border: 1px solid var(--color-border); }
                                                            .btn-reset:hover { background: var(--color-surface-muted); }

                                                            .btn-excel { background: var(--color-success); color: #fff; }
                                                            .btn-excel:hover { background: #15803d; }

                                                            .btn-pdf { background: var(--color-danger); color: #fff; }
                                                            .btn-pdf:hover { background: #b91c1c; }

                                                            @media (max-width: 900px) {
                                                                .filter-bar { align-items: stretch; }
                                                                .filter-bar select,
                                                                .filter-bar input[type="date"],
                                                                .btn-action { width: 100%; }
                                                            }
                                                        </style>
</head>
<body class="theme-siswa">

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <h1 class="page-title">Nilai Saya</h1>
            <p class="page-subtitle">Riwayat nilai tugas yang sudah dinilai guru.</p>

            <form method="GET" class="filter-bar">

                <select name="mapel_id">
                    <option value="">Semua Mapel</option>
                    <?php foreach ($mapelList as $m): ?>
                        <option value="<?= (int) $m['id'] ?>" <?= $filter_mapel == $m['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['nama_mapel']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="Sudah Dinilai" <?= $filter_status === 'Sudah Dinilai' ? 'selected' : '' ?>>Sudah Dinilai</option>
                    <option value="Belum Dinilai" <?= $filter_status === 'Belum Dinilai' ? 'selected' : '' ?>>Belum Dinilai</option>
                </select>

                <input type="date" name="tanggal_awal" value="<?= htmlspecialchars($filter_awal) ?>">
                <span class="filter-separator">s/d</span>
                <input type="date" name="tanggal_akhir" value="<?= htmlspecialchars($filter_akhir) ?>">

                <button type="submit" class="btn-action btn-filter">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>

                <a href="nilai.php" class="btn-action btn-reset">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>

                <a href="nilai_export_excel.php?<?= http_build_query($_GET) ?>" class="btn-action btn-excel">
                    <i class="fa-solid fa-file-excel"></i> Export Excel
                </a>

                <a href="nilai_export_pdf.php?<?= http_build_query($_GET) ?>" class="btn-action btn-pdf">
                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                </a>

            </form>

            <div class="table-box">
                <table>
                    <thead>
                        <tr>
                            <th>Tugas</th>
                            <th>Mapel</th>
                            <th>Status</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (mysqli_num_rows($riwayat) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($riwayat)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_tugas']); ?></td>
                            <td>
                                <?= !empty($row['nama_mapel'])
                                    ? htmlspecialchars($row['nama_mapel'])
                                    : '-'; ?>
                            </td>
                            <td>
                                <?php if($row['status'] == 'Sudah Dinilai'): ?>
                                    <span class="badge badge-success">Sudah Dinilai</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Belum Dinilai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $row['nilai'] > 0 ? $row['nilai'] : '-'; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center; padding:30px;">
                                Belum ada data nilai.
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

</body>
</html>