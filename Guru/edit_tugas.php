<?php

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$data = $controller->editTugas();

extract($data);

include '../app/Views/Guru/edit_tugas.php';
