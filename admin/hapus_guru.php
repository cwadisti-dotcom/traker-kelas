<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $koneksi,
    "DELETE FROM users
     WHERE id='$id'
     AND role='guru'"
);

echo "
<script>
alert('Data guru berhasil dihapus');
window.location='data_guru.php';
</script>
";
?>