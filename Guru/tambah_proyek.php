<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: ../auth/login.php");
}

include "../config/koneksi.php";

$data = mysqli_query($conn, "SELECT * FROM proyek ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Proyek</title>

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
    padding:40px;
    min-height:100vh;
}

.hero-box{
    background:linear-gradient(135deg,#b68d69,#d4b08c);
    border-radius:30px;
    padding:35px;
    margin-bottom:30px;
    color:white;
    position:relative;
    overflow:hidden;
}

.hero-box::before{
    content:'';
    position:absolute;
    width:220px;
    height:220px;
    background:rgba(255,255,255,0.15);
    border-radius:50%;
    top:-60px;
    right:-60px;
}

.hero-box h2{
    font-size:34px;
    margin-bottom:10px;
    position:relative;
    z-index:2;
}

.hero-box p{
    opacity:0.9;
    position:relative;
    z-index:2;
}

.statistik-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:35px;
}

.stat-card{
    background:#f7efe5;
    border-radius:25px;
    padding:25px;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);
}

.stat-card h3{
    font-size:15px;
    color:#7b6553;
    margin-bottom:10px;
}

.stat-card h1{
    color:#3e2f24;
    font-size:34px;
}

.proyek-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:35px;
}

.proyek-header h1{
    font-size:38px;
    color:#3e2f24;
}

.btn-tambah{
    background:#b68d69;
    color:white;
    text-decoration:none;
    padding:14px 22px;
    border-radius:16px;
    font-weight:600;
    transition:0.3s;
}

.btn-tambah:hover{
    background:#9f7653;
    transform:translateY(-2px);
}

.proyek-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
    gap:25px;
}

.proyek-card{
    background:#f7efe5;
    padding:25px;
    border-radius:28px;
    position:relative;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}

.proyek-card:hover{
    transform:translateY(-5px);
}

.proyek-card::before{
    content:'';
    position:absolute;
    width:120px;
    height:120px;
    background:rgba(255,255,255,0.3);
    border-radius:50%;
    top:-30px;
    right:-30px;
}

.proyek-card h3{
    font-size:24px;
    color:#3e2f24;
    margin-bottom:12px;
    position:relative;
    z-index:2;
}

.proyek-card p{
    color:#6d5a4a;
    font-size:15px;
    line-height:1.6;
    margin-bottom:20px;
    position:relative;
    z-index:2;
}

.deadline{
    display:inline-block;
    background:#fff;
    padding:10px 15px;
    border-radius:14px;
    font-size:14px;
    color:#7a604b;
    font-weight:500;
    position:relative;
    z-index:2;
}

.card-action{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.btn-detail,
.btn-edit,
.btn-delete{
    flex:1;
    text-align:center;
    padding:10px;
    border-radius:12px;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
    transition:0.3s;
}

.btn-detail{
    background:#d8c3a5;
    color:#3e2f24;
}

.btn-edit{
    background:#c6b199;
    color:#3e2f24;
}

.btn-delete{
    background:#e6b8b8;
    color:#7a1f1f;
}

.btn-detail:hover,
.btn-edit:hover,
.btn-delete:hover{
    transform:translateY(-2px);
}

.kosong{
    background:#f7efe5;
    padding:30px;
    border-radius:20px;
    text-align:center;
    color:#6d5a4a;
    font-size:18px;
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

        <a href="tambah_proyek.php" class="active">
            Proyek
        </a>

        <a href="tambah_tugas.php">
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

    <div class="hero-box">

        <h2>
            Halo, <?php echo $_SESSION['username']; ?> 
        </h2>

        <p>
            Kelola semua proyek dan deadline kamu dengan lebih rapi dan modern.
        </p>

    </div>

    <div class="statistik-grid">

        <div class="stat-card">
            <h3>Total Proyek</h3>

            <h1>
                <?php echo mysqli_num_rows($data); ?>
            </h1>
        </div>

        <div class="stat-card">
            <h3>Status</h3>

            <h1>Aktif </h1>
        </div>

        <div class="stat-card">
            <h3>Produktivitas</h3>

            <h1>98%</h1>
        </div>

    </div>

    <div class="proyek-header">

        <h1>Daftar Proyek </h1>

        <a href="form_proyek.php" class="btn-tambah">
            + Tambah Proyek
        </a>

    </div>

    <?php if(mysqli_num_rows($data) > 0){ ?>

    <div class="proyek-grid">

        <?php while($row = mysqli_fetch_assoc($data)){ ?>

        <div class="proyek-card">

            <h3>
                <?php echo $row['nama_proyek']; ?>
            </h3>

            <p>
                <?php echo $row['deskripsi']; ?>
            </p>

            <div class="deadline">
                📅 <?php echo $row['deadline']; ?>
            </div>

            <div class="card-action">

                <a href="detail_proyek.php?id=<?php echo $row['id']; ?>" class="btn-detail">
                    Detail
                </a>

                <a href="edit_proyek.php?id=<?php echo $row['id']; ?>" class="btn-edit">
                    Edit
                </a>

                <a 
                href="hapus_proyek.php?id=<?php echo $row['id']; ?>" 
                class="btn-delete"
                onclick="return confirm('Hapus proyek ini?')">
                    Hapus
                </a>

            </div>

        </div>

        <?php } ?>

    </div>

    <?php } else { ?>

    <div class="kosong">
        Belum ada proyek 
    </div>

    <?php } ?>

</div>

</body>
</html>