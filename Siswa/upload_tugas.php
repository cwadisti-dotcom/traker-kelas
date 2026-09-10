<?php

session_start();

include '../config/koneksi.php';
include '../app/Controllers/SiswaController.php';

$controller = new SiswaController($koneksi);

$data = $controller->uploadTugas();
extract($data);

include '../app/Views/Siswa/upload_tugas.php';
