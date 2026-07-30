<?php

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$controller->updateTugas();

$data = $controller->formEditTugas($_GET['id']);

extract($data);

include '../app/Views/Guru/form_edit_tugas.php';