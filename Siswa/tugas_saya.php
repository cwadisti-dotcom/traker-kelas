<?php

session_start();

include '../config/koneksi.php';
include '../app/Controllers/SiswaController.php';

$controller = new SiswaController($koneksi);

$data = $controller->tugasSaya();
extract($data);

include '../app/Views/Siswa/tugas_saya.php';
