<?php

session_start();

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$data = $controller->tugas();
extract($data);

include '../app/Views/Guru/tugas.php';