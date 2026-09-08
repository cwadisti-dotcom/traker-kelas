<?php

include __DIR__.'/../../config/koneksi.php';

include __DIR__.'/../Models/TugasModel.php';
include __DIR__.'/../Models/PengumpulanModel.php';
include __DIR__.'/../Models/UserModel.php';
include __DIR__.'/../Models/MapelModel.php';


class GuruController
{
    private $tugasModel;
    private $pengumpulanModel;
    private $userModel;
    private $mapelModel;

    public function __construct($koneksi)
    {
        $this->tugasModel = new TugasModel($koneksi);
        $this->pengumpulanModel = new PengumpulanModel($koneksi);
        $this->userModel = new UserModel($koneksi);
        $this->mapelModel = new MapelModel($koneksi);
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

    public function mapel()
    {
        if(isset($_GET['hapus']))
        {
            $this->mapelModel->hapus($_GET['hapus']);

            header("Location: mapel.php");
            exit;
        }

        if(isset($_POST['simpan_mapel']))
        {
            $this->mapelModel->tambah($_POST['nama_mapel']);

            header("Location: mapel.php");
            exit;
        }

        if(isset($_POST['update_mapel']))
        {
            $this->mapelModel->update(
                $_POST['id'],
                $_POST['nama_mapel']
            );

            header("Location: mapel.php");
            exit;
        }

        return [
            'mapelList' => $this->mapelModel->getAll()
        ];
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

    public function tugas()
    {
        if(isset($_GET['hapus']))
        {
            $this->tugasModel->hapus($_GET['hapus']);

            header("Location: tugas.php");
            exit;
        }

        if(isset($_POST['simpan']))
        {
            $nama_tugas = $_POST['nama_tugas'];
            $mapel_id   = $_POST['mapel_id'];
            $deskripsi  = $_POST['deskripsi'];
            $deadline   = $_POST['deadline'];
            $guru_id    = $_SESSION['id'] ?? null;

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
                $guru_id,
                $mapel_id
            );

            header("Location: tugas.php");
            exit;
        }

        if(isset($_POST['update']))
        {
            $this->tugasModel->update(
                $_POST['id'],
                $_POST['nama_tugas'],
                $_POST['mapel_id'],
                $_POST['deskripsi'],
                $_POST['deadline']
            );

            header("Location: tugas.php");
            exit;
        }

        return [
            'tugas' => $this->tugasModel->getAll(),
            'mapelList' => $this->mapelModel->getAll()
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