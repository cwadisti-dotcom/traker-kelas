<?php

session_start();

include '../config/koneksi.php';
include '../app/Controllers/SiswaController.php';

$controller = new SiswaController($koneksi);

$data = $controller->detailTugas();
extract($data);

include '../app/Views/Siswa/detail_tugas.php';