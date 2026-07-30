<?php

include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $koneksi,
    "DELETE FROM users
    WHERE id='$id'
    AND role='siswa'"
);

header("Location:data_siswa.php");
exit;