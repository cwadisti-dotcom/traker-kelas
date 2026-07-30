<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Tugas</title>

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
Edit Tugas
</h1>

<p class="page-subtitle">
Perbarui data tugas.
</p>

<div class="form-box">

<form method="POST">

<input
type="hidden"
name="id"
value="<?= $tugas['id']; ?>">

<div class="form-group">

<label>Nama Tugas</label>

<input
type="text"
name="nama_tugas"
class="form-input"
value="<?= $tugas['nama_tugas']; ?>"
required>

</div>

<div class="form-group">

<label>Mapel</label>

<input
type="text"
name="mapel"
class="form-input"
value="<?= $tugas['mapel']; ?>"
required>

</div>

<div class="form-group">

<label>Deskripsi</label>

<textarea
name="deskripsi"
class="form-textarea"
required><?= $tugas['deskripsi']; ?></textarea>

</div>

<div class="form-group">

<label>Deadline</label>

<input
type="date"
name="deadline"
class="form-input"
value="<?= $tugas['deadline']; ?>"
required>

</div>

<button
type="submit"
name="update"
class="submit-btn">

Update Tugas

</button>

</form>

</div>

</div>

</div>

</div>

</body>
</html>