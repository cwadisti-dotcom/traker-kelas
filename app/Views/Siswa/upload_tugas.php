<?php
include '../config/koneksi.php';

if(isset($_POST['upload'])){

    $tugas_id = $_POST['tugas_id'];
    $catatan  = $_POST['catatan'];

    $namaFile = $_FILES['file']['name'];
    $tmpFile  = $_FILES['file']['tmp_name'];

    move_uploaded_file(
        $tmpFile,
        "../uploads/jawaban/" . $namaFile
    );

    $query = mysqli_query(
    $koneksi,
    "INSERT INTO pengumpulan_tugas
    (
        tugas_id,
        siswa,
        jawaban,
        file_jawaban
    )
    VALUES
    (
        '$tugas_id',
        'siswa1',
        '$catatan',
        '$namaFile'
    )"
    );

    if($query){
        echo "INSERT BERHASIL";
    }else{
        die(mysqli_error($koneksi));
    }

    echo "
    <script>
        alert('Jawaban berhasil dikirim');
        window.location='tugas_saya.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Upload Jawaban</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/siswa.css">

    <!-- ICON -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

</head>
<body>

<div class="container">

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="sidebar-top">

            <div class="logo">
                <h2>DeadlineHub</h2>
            </div>

            <div class="menu-title">
                SISWA
            </div>

            <ul class="menu">

                <li>
                    <a href="index.php">
                        <i class="fa-solid fa-table-columns"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="tugas_saya.php">
                        <i class="fa-regular fa-clipboard"></i>
                        Tugas Saya
                    </a>
                </li>

                <li class="active">
                    <a href="upload_tugas.php">
                        <i class="fa-solid fa-upload"></i>
                      Upload Jawaban siswa
                    </a>
                </li>

                <li>
                    <a href="nilai.php">
                        <i class="fa-solid fa-chart-column"></i>
                        Nilai
                    </a>
                </li>

            </ul>

        </div>

        <ul class="menu">

            <li class="logout">
                <a href="../auth/logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- MAIN -->

    <main class="main-content">

        <!-- TOPBAR -->

        <div class="topbar">
            
            <div class="profile">

                <div class="user-box">

                    <div class="user-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <span>Siswa</span>

                </div>

            </div>

        </div>

        <!-- TITLE -->

        <div class="page-title">

            <h1>Upload Jawaban</h1>

            <p>
                Upload file tugas yang sudah kamu kerjakan.
            </p>

        </div>

        <!-- FORM -->

        <div class="upload-wrapper">

            <form action="" method="POST"
            enctype="multipart/form-data"
            class="upload-form">

                <div class="upload-card">

                    <div class="upload-icon">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>

                    <h2>Upload Tugas </h2>

                    <p>
                        Pastikan file sesuai format yang ditentukan guru.
                    </p>

                </div>

                <!-- SELECT TUGAS -->

                <div class="form-group">

                    <label>Pilih Tugas</label>

                    <select name="tugas_id" required>

                    <option value="">
                        -- Pilih Tugas --
                    </option>

                    <?php

                    $tugas = mysqli_query(
                        $koneksi,
                        "SELECT * FROM tugas ORDER BY deadline ASC"
                    );

                    while($row = mysqli_fetch_assoc($tugas)):

                    ?>

                    <option value="<?= $row['id']; ?>">
                        <?= $row['nama_tugas']; ?>
                    </option>

                    <?php endwhile; ?>

                    </select>

                </div>

                <!-- CATATAN -->

                <div class="form-group">

                    <label>Catatan</label>

                    <textarea
                    name="catatan"
                    placeholder="Tambahkan catatan untuk guru..."></textarea>

                </div>

                <!-- FILE -->

                <div class="form-group">

                    <label>Upload File</label>

                    <input type="file" name="file">

                </div>

                <!-- BUTTON -->

                <button type="submit" name="upload" class="btn-submit">

                    <i class="fa-solid fa-paper-plane"></i>

                    Kirim Jawaban

                </button>

            </form>

        </div>

    </main>

</div>

</body>
</html>