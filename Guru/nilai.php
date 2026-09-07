<?php

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$controller->simpanNilai();

$data = $controller->nilai();

extract($data);

include '../app/Views/Guru/nilai.php';
