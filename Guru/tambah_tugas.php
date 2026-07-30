<?php

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$controller->tambahTugas();

include '../app/Views/Guru/tambah_tugas.php';