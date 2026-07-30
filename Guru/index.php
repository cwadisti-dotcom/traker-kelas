<?php

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$data = $controller->dashboard();

extract($data);

include '../app/Views/Guru/index.php';