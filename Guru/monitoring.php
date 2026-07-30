<?php

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$data = $controller->monitoring();

extract($data);

include '../app/Views/Guru/monitoring.php';