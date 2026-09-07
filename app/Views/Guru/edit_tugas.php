<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Edit Tugas</title>

    <link rel="stylesheet" href="../assets/css/guru.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="wrapper">

    <?php include 'sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <h1 class="page-title">
                Edit Tugas
            </h1>

            <p class="page-subtitle">
                Kelola dan edit tugas yang sudah dibuat.
            </p>

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

                    <td><?= $row['nama_tugas']; ?></td>

                    <td><?= $row['mapel']; ?></td>

                    <td>
                        <?= date('d M Y', strtotime($row['deadline'])); ?>
                    </td>

                    <td><?= $row['status']; ?></td>

                    <td>

                        <a href="form_edit_tugas.php?id=<?= $row['id']; ?>"
                        class="btn-edit">
                        Edit
                        </a>

                        <a href="hapus_tugas.php?id=<?= $row['id']; ?>"
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

</body>
</html>