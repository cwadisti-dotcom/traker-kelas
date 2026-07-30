<?php

require_once __DIR__ . '/../Models/TugasModel.php';

class TugasController
{
    private $tugasModel;

    public function __construct($koneksi)
    {
        $this->tugasModel = new TugasModel($koneksi);
    }

    public function getAllTugas()
    {
        return $this->tugasModel->getAll();
    }

    public function getTotalTugas()
    {
        return $this->tugasModel->getTotal();
    }

    public function getDashboardGuru()
    {
        return $this->tugasModel->getDashboardGuru();
    }

    public function getById($id)
    {
        return $this->tugasModel->getById($id);
    }

    public function tambahTugas(
        $nama_tugas,
        $deskripsi,
        $file_pdf,
        $deadline,
        $guru,
        $mapel
    )
    {
        return $this->tugasModel->tambah(
            $nama_tugas,
            $deskripsi,
            $file_pdf,
            $deadline,
            $guru,
            $mapel
        );
    }

    public function updateTugas(
        $id,
        $nama_tugas,
        $mapel,
        $deskripsi,
        $deadline
    )
    {
        return $this->tugasModel->update(
            $id,
            $nama_tugas,
            $mapel,
            $deskripsi,
            $deadline
        );
    }

    public function hapusTugas($id)
    {
        return $this->tugasModel->hapus($id);
    }
}