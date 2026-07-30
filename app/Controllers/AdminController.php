<?php

require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/TugasModel.php';

class AdminController
{
    private $userModel;
    private $tugasModel;

    public function __construct($koneksi)
    {
        $this->userModel = new UserModel($koneksi);
        $this->tugasModel = new TugasModel($koneksi);
    }

    public function totalGuru()
    {
        return $this->userModel->getTotalGuru();
    }

    public function totalSiswa()
    {
        return $this->userModel->getTotalSiswa();
    }

    public function totalTugas()
    {
        return $this->tugasModel->getTotal();
    }

    public function monitoring()
    {
        return $this->tugasModel->getAll();
    }
}