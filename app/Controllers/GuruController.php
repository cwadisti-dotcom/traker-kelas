<?php

include __DIR__.'/../../config/koneksi.php';

include __DIR__.'/../Models/TugasModel.php';
include __DIR__.'/../Models/PengumpulanModel.php';
include __DIR__.'/../Models/UserModel.php';


class GuruController
{
    private $tugasModel;
    private $pengumpulanModel;
    private $userModel;

    public function __construct($koneksi)
    {
        $this->tugasModel = new TugasModel($koneksi);
        $this->pengumpulanModel = new PengumpulanModel($koneksi);
        $this->userModel = new UserModel($koneksi);
    }

    public function dashboard()
    {
        $totalTugas =
            $this->tugasModel->getTotal();

        $totalUpload =
            $this->pengumpulanModel->getTotalUpload();

        $totalDinilai =
            $this->pengumpulanModel->getTotalDinilai();

        $totalBelumDinilai =
            $totalUpload - $totalDinilai;

        $tugas =
            $this->tugasModel->getDashboardGuru();

        return [
            'totalTugas' => $totalTugas,
            'totalUpload' => $totalUpload,
            'totalDinilai' => $totalDinilai,
            'totalBelumDinilai' => $totalBelumDinilai,
            'tugas' => $tugas
        ];
    }

    public function tambahTugas()
    {
        if(isset($_POST['simpan']))
        {
            $nama_tugas = $_POST['nama_tugas'];
            $mapel      = $_POST['mapel'];
            $deskripsi  = $_POST['deskripsi'];
            $deadline   = $_POST['deadline'];
            $guru       = "Guru";

            $file_pdf = '';

            if($_FILES['file_pdf']['name'] != '')
            {
                $namaFile = $_FILES['file_pdf']['name'];
                $tmpFile  = $_FILES['file_pdf']['tmp_name'];

                move_uploaded_file(
                    $tmpFile,
                    __DIR__ . '/../../uploads/tugas/' . $namaFile
                );

                $file_pdf = $namaFile;
            }

            $this->tugasModel->tambah(
                $nama_tugas,
                $deskripsi,
                $file_pdf,
                $deadline,
                $guru,
                $mapel
            );

            header("Location: index.php");
            exit;
        }
    }

    public function monitoring()
    {
        return [

            'totalUpload' =>
                $this->pengumpulanModel->getTotalUpload(),

            'totalBelumUpload' =>
                $this->pengumpulanModel->getTotalBelumUpload(),

            'totalTugasAktif' =>
                $this->tugasModel->getTotalAktif(),

            'totalSiswa' =>
                $this->userModel->getTotalSiswa(),

            'monitor' =>
                $this->pengumpulanModel->getMonitoring()
        ];
    }

   public function formEditTugas($id)
    {
        return [
            'tugas' => $this->tugasModel->getById($id)
        ];
    }

   public function updateTugas()
    {
        if(isset($_POST['update']))
        {
            $this->tugasModel->update(
                $_POST['id'],
                $_POST['nama_tugas'],
                $_POST['mapel'],
                $_POST['deskripsi'],
                $_POST['deadline']
            );

            header("Location: edit_tugas.php");
            exit;
        }
    }

    public function hapusTugas($id)
    {
        $this->tugasModel->hapus($id);

        header("Location: edit_tugas.php");
        exit;
    }

    public function editTugas()
    {
        return [
            'tugas' => $this->tugasModel->getAll()
        ];
    }

    public function nilai()
    {
        return [
            'sudahDinilai' => $this->pengumpulanModel->getTotalDinilai(),
            'belumDinilai' => $this->pengumpulanModel->getTotalBelumDinilai(),
            'jawabanMasuk' => $this->pengumpulanModel->getTotal(),
            'totalSiswa'   => $this->userModel->getTotalSiswa(),
            'pengumpulan'  => $this->pengumpulanModel->getAllWithTugas()
        ];
    }

    public function simpanNilai()
    {
        if(isset($_POST['simpan_nilai']))
        {
            $this->pengumpulanModel->updateNilai(
                $_POST['id'],
                $_POST['nilai']
            );

            header("Location: nilai.php");
            exit;
        }
    }
}