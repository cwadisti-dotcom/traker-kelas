<?php
session_start();
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Siswa</title>

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
                Kelola Siswa
            </h1>

            <p class="page-subtitle">
                Kelola seluruh data siswa yang terdaftar.
            </p>

            <div class="card">

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    margin-bottom:20px;
                ">

                    <a href="tambah_siswa.php" class="btn-add">
                        <i class="fas fa-plus"></i>
                        Tambah Siswa
                    </a>

                </div>

                <div class="table-wrapper">


                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $query = mysqli_query(
                            $koneksi,
                            "SELECT * FROM users WHERE role='guru'"
                        );

                        $no = 1;

                        while($data = mysqli_fetch_assoc($query))
                        {
                        ?>

                        <tr>

                            <td><?= $no++ ?></td>
                            <td><?= $data['id'] ?></td>
                            <td><?= $data['username'] ?></td>
                            <td><?= $data['role'] ?></td>

                            <td>

                                <a href="edit_guru.php?id=<?= $data['id'] ?>"
                                class="btn-edit">
                                    Edit
                                </a>

                                <a href="hapus_guru.php?id=<?= $data['id'] ?>"
                                class="btn-delete"
                                onclick="return confirm('Yakin ingin menghapus guru ini?')">
                                    Hapus
                                </a>

                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>


                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>