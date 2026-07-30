<?php
session_start();

include "../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM proyek WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $nama = $_POST['nama_proyek'];
    $deskripsi = $_POST['deskripsi'];
    $deadline = $_POST['deadline'];

    mysqli_query($conn, "UPDATE proyek SET
    nama_proyek='$nama',
    deskripsi='$deskripsi',
    deadline='$deadline'
    WHERE id='$id'");

    header("Location: tambah_proyek.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Proyek</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family:'Poppins',sans-serif;
    background:#ebe1d3;
    padding:40px;
}

.form-box{
    background:#f7efe5;
    max-width:700px;
    margin:auto;
    padding:35px;
    border-radius:30px;
}

h1{
    margin-bottom:25px;
    color:#3e2f24;
}

input,
textarea{
    width:100%;
    padding:15px;
    margin-bottom:20px;
    border:none;
    border-radius:14px;
}

button{
    background:#b68d69;
    color:white;
    border:none;
    padding:15px 20px;
    border-radius:14px;
    cursor:pointer;
}

</style>

</head>

<body>

<div class="form-box">

    <h1>Edit Proyek ✏️</h1>

    <form method="POST">

        <input 
        type="text"
        name="nama_proyek"
        value="<?php echo $row['nama_proyek']; ?>"
        required>

        <textarea 
        name="deskripsi"
        required><?php echo $row['deskripsi']; ?></textarea>

        <input 
        type="date"
        name="deadline"
        value="<?php echo $row['deadline']; ?>"
        required>

        <button type="submit" name="update">
            Update Proyek
        </button>

    </form>

</div>

</body>
</html>