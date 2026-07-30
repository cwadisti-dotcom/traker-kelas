<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: ../auth/login.php");
}

include "../config/koneksi.php";

    $proyek = mysqli_query($conn, "SELECT * FROM proyek");

if(isset($_POST['simpan'])){

    $nama_tugas = $_POST['nama_tugas'];
    $deadline = $_POST['deadline'];
    $prioritas = $_POST['prioritas'];
    $proyek_id = $_POST['proyek_id'];

    mysqli_query($conn, "INSERT INTO tugas
    (nama_tugas, deadline, prioritas, proyek_id)
    VALUES
    ('$nama_tugas','$deadline','$prioritas','$proyek_id')");

    header("Location: tambah_tugas.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Tugas</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#ebe1d3;
}

.main{
    margin-left:240px;
    min-height:100vh;
    padding:40px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.form-box{
    width:100%;
    max-width:700px;
    background:#f7efe5;
    padding:40px;
    border-radius:30px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.form-box h1{
    color:#3e2f24;
    font-size:38px;
    margin-bottom:10px;
}

.form-box p{
    color:#7b6553;
    margin-bottom:30px;
}

.input-group{
    margin-bottom:22px;
}

.input-group label{
    display:block;
    margin-bottom:10px;
    color:#5c4635;
    font-weight:600;
}

.input-group input,
.input-group select{
    width:100%;
    padding:16px;
    border:none;
    border-radius:16px;
    background:white;
    outline:none;
    font-size:15px;
}

button{
    width:100%;
    padding:16px;
    border:none;
    border-radius:16px;
    background:#b68d69;
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#9f7653;
}

.kembali{
    display:inline-block;
    margin-top:20px;
    text-decoration:none;
    color:#6d5a4a;
    font-weight:500;
}

</style>

</head>

<body>

<div class="sidebar">

    <div class="logo">
        <h2>DeadlineHub</h2>
    </div>

    <div class="menu">

        <a href="index.php">
            Dashboard
        </a>

        <a href="tambah_proyek.php">
            Proyek
        </a>

        <a href="tambah_tugas.php" class="active">
            Tugas
        </a>

        <a href="laporan.php">
            Laporan
        </a>

        <a href="../auth/logout.php">
            Logout
        </a>

    </div>

</div>

<div class="main">

    <div class="form-box">

        <h1>Tambah Tugas ✨</h1>

        <p>
            Tambahkan tugas dan atur deadline kamu.
        </p>

        <form method="POST">

            <div class="input-group">

                <label>Nama Tugas</label>

                <input 
                type="text"
                name="nama_tugas"
                placeholder="Masukkan nama tugas..."
                required>

            </div>

            <div class="input-group">

                <label>Deadline</label>

                <input 
                type="date"
                name="deadline"
                required>

            </div>

            <div class="input-group">
                
            <div class="input-group">

                <label>Proyek</label>

                <select name="proyek_id" required>

                    <option value="">
                        Pilih Proyek
                    </option>

                    <?php while($p = mysqli_fetch_assoc($proyek)){ ?>

                    <option value="<?php echo $p['id']; ?>">

                        <?php echo $p['nama_proyek']; ?>

                    </option>

                    <?php } ?>

                </select>

            </div>


                <label>Prioritas</label>

                <select name="prioritas">

                    <option value="Tinggi">
                        Tinggi
                    </option>

                    <option value="Sedang">
                        Sedang
                    </option>

                    <option value="Rendah">
                        Rendah
                    </option>

                </select>

            </div>

            <button type="submit" name="simpan">
                Simpan Tugas
            </button>

        </form>

        <a href="tambah_tugas.php" class="kembali">
            ← Kembali ke daftar tugas
        </a>

    </div>

</div>

</body>
</html>
