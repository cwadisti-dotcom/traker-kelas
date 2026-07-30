<?php

require_once __DIR__ . '/../Models/UserModel.php';

class SiswaController
{
    private $userModel;

    public function __construct($koneksi)
    {
        $this->userModel = new UserModel($koneksi);
    }

    public function getAllSiswa()
    {
        return $this->userModel->getSiswa();
    }

    public function getTotalSiswa()
    {
        return $this->userModel->getTotalSiswa();
    }
}