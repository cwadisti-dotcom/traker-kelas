<?php

session_start();

include '../config/koneksi.php';
include '../app/Controllers/SiswaController.php';

$controller = new SiswaController($koneksi);

$data = $controller->dashboard();
extract($data);

include '../app/Views/Siswa/index.php';
