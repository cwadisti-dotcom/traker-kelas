<?php

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$data = $controller->mapel();
extract($data);

include '../app/Views/Guru/mapel.php';