<?php
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Monitoring</title>

    <link rel="stylesheet" href="../assets/css/admin.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="container">

    <?php include 'sidebar.php'; ?>

    <div class="content">

        <div class="page-wrapper">

            <h1 class="page-title">
                Monitoring
            </h1>

            <p class="page-subtitle">
                Monitoring seluruh tugas yang tersedia.
            </p>

            <div class="table-card">

                <table class="monitor-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tugas</th>
                            <th>Guru</th>
                            <th>Mapel</th>
                            <th>Deadline</th>
                            <th>Progress</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    $tugas = mysqli_query(
                        $koneksi,
                        "SELECT * FROM tugas ORDER BY deadline ASC"
                    );

                    while($row = mysqli_fetch_assoc($tugas)):
                    ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td><?= $row['nama_tugas']; ?></td>

                        <td>
                            <?= !empty($row['guru'])
                            ? $row['guru']
                            : '-'; ?>
                        </td>

                        <td>
                            <?= !empty($row['mapel'])
                            ? $row['mapel']
                            : '-'; ?>
                        </td>

                        <td>
                            <?= date(
                                'd M Y',
                                strtotime($row['deadline'])
                            ); ?>
                        </td>

                        <td>
                            <?= $row['progress']; ?>%
                        </td>

                        <td>
                            <span class="status-badge">
                                <?= $row['status']; ?>
                            </span>
                        </td>

                    </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>