<?php
include '../config/koneksi.php';

if(isset($_POST['simpan'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query(
        $koneksi,
        "INSERT INTO users(username,password,role)
        VALUES(
            '$username',
            '$password',
            'guru'
        )"
    );

    echo "
    <script>
        alert('Guru berhasil ditambahkan');
        window.location='data_guru.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Guru</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="container">

    <?php include 'sidebar.php'; ?>

    <div class="content">

        <div class="page-title">

            <h1>Tambah Guru</h1>

            <p>
                Tambahkan akun guru baru ke sistem.
            </p>

        </div>

        <div class="table-card">

            <form method="POST">

                <div class="form-group">

                    <label>Username Guru</label>

                    <input
                    type="text"
                    name="username"
                    class="form-control"
                    required>

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input
                    type="password"
                    name="password"
                    class="form-control"
                    required>

                </div>

                <button
                type="submit"
                name="simpan"
                class="btn btn-primary">

                    Simpan Guru

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>