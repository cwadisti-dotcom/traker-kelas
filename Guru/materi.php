<?php

session_start();

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$data = $controller->materi();
extract($data);

include '../app/Views/Guru/materi.php';