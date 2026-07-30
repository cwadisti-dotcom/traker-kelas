<?php

include '../config/koneksi.php';
include '../app/Controllers/GuruController.php';

$controller = new GuruController($koneksi);

$id = $_GET['id'];

$controller->hapusTugas($id);