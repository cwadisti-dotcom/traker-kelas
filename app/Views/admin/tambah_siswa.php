<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Siswa</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="container">

    <?php include 'sidebar.php'; ?>

    <div class="content">

        <div class="page-wrapper">

    <div class="page-header">
        <h1 class="page-title">Tambah Siswa</h1>
        <p class="page-subtitle">
            Tambahkan akun siswa baru ke sistem.
        </p>
    </div>

    <div class="card">
        <form method="POST">

            <div class="form-group">
                <label>Username Siswa</label>
                <input
                    type="text"
                    name="username"
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >
            </div>

            <button type="submit" class="btn-primary">
                Simpan Siswa
            </button>

        </form>
    </div>

</div>

    </div>

</div>

</body>
</html>