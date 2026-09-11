<?php

session_start();

include '../config/koneksi.php';
include '../app/Controllers/SiswaController.php';

$controller = new SiswaController($koneksi);

$data = $controller->detailMateri();
extract($data);

include '../app/Views/Siswa/detail_materi.php';