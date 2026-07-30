<?php
include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM users WHERE id='$id'"
);

$siswa = mysqli_fetch_assoc($data);

if(isset($_POST['update']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query(
        $koneksi,
        "UPDATE users
        SET
        username='$username',
        password='$password'
        WHERE id='$id'"
    );

    echo "
    <script>
    alert('Data berhasil diperbarui');
    window.location='data_siswa.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Siswa - DeadlineHub</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="container">

    <?php include 'sidebar.php'; ?>

    <div class="content">

    <div class="page-wrapper">

        <h1 class="page-title">
            Edit Siswa
        </h1>

        <p class="page-subtitle">
            Perbarui data siswa.
        </p>

        <div class="form-card">

            <form method="POST">

                <div class="form-group">

                    <label>Username</label>

                    <input
                    type="text"
                    name="username"
                    class="form-control"
                    value="<?= htmlspecialchars($siswa['username']); ?>"
                    required>

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input
                    type="text"
                    name="password"
                    class="form-control"
                    value="<?= htmlspecialchars($siswa['password']); ?>"
                    required>

                </div>

                <button
                type="submit"
                name="update"
                class="btn btn-primary">

                    Update Siswa

                </button>

            </form>

        </div>

    </div>

</div>

</div>

</body>
</html>