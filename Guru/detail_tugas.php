<?php
session_start();

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);
$tugas_id   = $_GET['id'] ?? 0;
$data       = $controller->viewersTugas($tugas_id);
extract($data);

include '../app/Views/Guru/detail_tugas.php';