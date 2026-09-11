<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Jawaban</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body class="theme-siswa">

<div class="wrapper">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">

        <div class="content-box">

            <h1 class="page-title">Upload Jawaban</h1>
            <p class="page-subtitle">Upload file tugas yang sudah kamu kerjakan.</p>
<form method="POST" enctype="multipart/form-data">


                <div class="form-box">

                    <div class="form-intro">
                        <div class="icon-circle">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <div>
                            <h2>Upload Tugas</h2>
                            <p>Pastikan file sesuai format yang ditentukan guru.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Pilih Tugas</label>
<select name="tugas_id" id="pilih_tugas" class="form-input" required>
    <option value="">-- Pilih Tugas --</option>
    <?php while ($row = mysqli_fetch_assoc($tugasList)): ?>
        <option value="<?= $row['id']; ?>" <?= (isset($_GET['id']) && $_GET['id'] == $row['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($row['nama_tugas']); ?>
        </option>
    <?php endwhile; ?>
</select>
                    </div>

                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea
                            name="catatan"
                            class="form-textarea"
                            placeholder="Tambahkan catatan untuk guru..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload File</label>
                        <input type="file" name="file" class="form-file">
                    </div>

                    <button type="submit" name="upload" class="submit-btn">
                        <i class="fa-solid fa-paper-plane"></i>
                        Kirim Jawaban
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>
