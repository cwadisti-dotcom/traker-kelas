<?php
session_start();

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);
$materi_id  = $_GET['id'] ?? 0;
$data       = $controller->viewers($materi_id);
extract($data);

include '../app/Views/Guru/detail_materi.php';