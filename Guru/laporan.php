<?php

session_start();

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$data = $controller->laporan();

extract($data);

include '../app/Views/Guru/laporan.php';