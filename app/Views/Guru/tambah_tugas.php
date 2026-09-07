<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>Tambah Tugas</title>

<link rel="stylesheet" href="../assets/css/guru.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="wrapper">

<?php include 'sidebar.php'; ?>

<div class="main-content">

<div class="content-box">

<h1 class="page-title">
Tambah Tugas
</h1>

<p class="page-subtitle">
Tambahkan tugas baru untuk siswa.
</p>

<div class="form-box">

<form method="POST" enctype="multipart/form-data">

<div class="form-group">
<label>Nama Tugas</label>

<input
type="text"
name="nama_tugas"
class="form-input"
required>
</div>

<div class="form-group">
<label>Mapel</label>

<input
type="text"
name="mapel"
class="form-input"
required>
</div>

<div class="form-group">
<label>Deskripsi</label>

<textarea
name="deskripsi"
class="form-textarea"
required></textarea>
</div>

<div class="form-group">
<label>Deadline</label>

<input
type="date"
name="deadline"
class="form-input"
required>
</div>

<div class="form-group">
<label>Upload PDF</label>

<input
type="file"
name="file_pdf"
accept=".pdf"
class="form-file">
</div>

<button
type="submit"
name="simpan"
class="submit-btn">

Simpan Tugas

</button>

</form>

</div>

</div>

</div>

</div>

</body>
</html>