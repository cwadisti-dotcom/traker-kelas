<?php

include __DIR__.'/../../config/koneksi.php';

include __DIR__.'/../Models/TugasModel.php';
include __DIR__.'/../Models/PengumpulanModel.php';
include __DIR__.'/../Models/UserModel.php';
include __DIR__.'/../Models/MapelModel.php';
include __DIR__.'/../Models/MateriModel.php';
include __DIR__.'/../Models/LaporanModel.php';


class GuruController
{
    private $tugasModel;
    private $pengumpulanModel;
    private $userModel;
    private $mapelModel;
    private $materiModel;
    private $laporanModel;

    public function __construct($koneksi)
    {
        $this->tugasModel = new TugasModel($koneksi);
        $this->pengumpulanModel = new PengumpulanModel($koneksi);
        $this->userModel = new UserModel($koneksi);
        $this->mapelModel = new MapelModel($koneksi);
        $this->materiModel = new MateriModel($koneksi);
        $this->laporanModel = new LaporanModel($koneksi);
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

    public function materi()
    {
        $error = null;

        if(isset($_GET['hapus']))
        {
            $this->materiModel->hapus($_GET['hapus']);

            header("Location: materi.php");
            exit;
        }

        if(isset($_POST['simpan_materi']))
        {
            $judul     = $_POST['judul'];
            $deskripsi = $_POST['deskripsi'];
            $mapel_id  = $_POST['mapel_id'];
            $guru_id   = $_SESSION['id'] ?? null;

            $file_materi = $this->uploadMateri($_FILES['file_materi']);

            if($file_materi === false)
            {
                $error = "Format file tidak didukung. Hanya file PDF yang diperbolehkan.";
            }
            else
            {
                $this->materiModel->tambah(
                    $judul,
                    $deskripsi,
                    $file_materi,
                    $mapel_id,
                    $guru_id
                );

                header("Location: materi.php");
                exit;
            }
        }

        if(isset($_POST['update_materi']))
        {
            $file_materi = null;

            if(!empty($_FILES['file_materi']['name']))
            {
                $file_materi = $this->uploadMateri($_FILES['file_materi']);
            }

            if($file_materi === false)
            {
                $error = "Format file tidak didukung. Hanya file PDF yang diperbolehkan.";
            }
            else
            {
                $this->materiModel->update(
                    $_POST['id'],
                    $_POST['judul'],
                    $_POST['mapel_id'],
                    $_POST['deskripsi'],
                    $file_materi
                );

                header("Location: materi.php");
                exit;
            }
        }

        return [
            'materi' => $this->materiModel->getAll(),
            'mapelList' => $this->mapelModel->getAll(),
            'error' => $error
        ];
    }

    private function uploadMateri($file)
    {
        if(empty($file['name']))
        {
            return '';
        }

        $allowedExt = ['pdf'];

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if(!in_array($ext, $allowedExt))
        {
            return false;
        }

        $namaBaru = uniqid('materi_') . '.' . $ext;

        move_uploaded_file(
            $file['tmp_name'],
            __DIR__ . '/../../uploads/materi/' . $namaBaru
        );

        return $namaBaru;
    }

    public function tugas()
    {
        $error = null;

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

            $file_pdf = $this->uploadTugasFile($_FILES['file_pdf']);

            if($file_pdf === false)
            {
                $error = "Format file tidak didukung. Hanya file PDF yang diperbolehkan.";
            }
            else
            {
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
            'mapelList' => $this->mapelModel->getAll(),
            'error' => $error
        ];
    }

    private function uploadTugasFile($file)
    {
        if(empty($file['name']))
        {
            return '';
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if($ext !== 'pdf')
        {
            return false;
        }

        $namaBaru = uniqid('tugas_') . '.' . $ext;

        $folderTujuan = __DIR__ . '/../../uploads/tugas/';

        if(!is_dir($folderTujuan))
        {
            mkdir($folderTujuan, 0777, true);
        }

        move_uploaded_file(
            $file['tmp_name'],
            $folderTujuan . $namaBaru
        );

        return $namaBaru;
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
    public function laporan()
{
    $mapel_id      = $_GET['mapel_id'] ?? null;
    $status        = $_GET['status'] ?? null;
    $tanggal_awal  = $_GET['tanggal_awal'] ?? null;
    $tanggal_akhir = $_GET['tanggal_akhir'] ?? null;

    $rekap = $this->laporanModel->getRekapNilai(
        $mapel_id, $status, $tanggal_awal, $tanggal_akhir
    );

    return [
        'rekap'         => $rekap,
        'mapelList'     => $this->mapelModel->getAll(),
        'filter_mapel'  => $mapel_id,
        'filter_status' => $status,
        'filter_awal'   => $tanggal_awal,
        'filter_akhir'  => $tanggal_akhir
    ];
}   
}