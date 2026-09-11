<?php

require_once __DIR__ . '/../Models/TugasModel.php';
require_once __DIR__ . '/../Models/PengumpulanModel.php';

class SiswaController
{
    private $tugasModel;
    private $pengumpulanModel;

   private $koneksi;

public function __construct($koneksi)
{
    $this->koneksi = $koneksi;
    $this->tugasModel = new TugasModel($koneksi);
    $this->pengumpulanModel = new PengumpulanModel($koneksi);
}

    public function dashboard()
    {
        $siswa_id = $_SESSION['id'] ?? null;

        $totalTugas   = $this->tugasModel->getTotal();
        $tugasSelesai = $this->pengumpulanModel->getTotalSelesaiBySiswa($siswa_id);

        $belumSelesai = $totalTugas - $tugasSelesai;

        if ($belumSelesai < 0) {
            $belumSelesai = 0;
        }

        return [
            'totalTugas'    => $totalTugas,
            'tugasSelesai'  => $tugasSelesai,
            'belumSelesai'  => $belumSelesai,
            'terlambat'     => $this->tugasModel->getTotalTerlambat($siswa_id),
            'tugasTerdekat' => $this->tugasModel->getDashboardSiswa($siswa_id, 5)
        ];
    }

public function tugasSaya()
{
    $siswa_id = $_SESSION['id'] ?? null;

    return [
        'tugas' => $this->tugasModel->getAllWithStatusSiswa($siswa_id)
    ];
}
public function detailTugas()
{
    $id       = $_GET['id'] ?? 0;
    $siswa_id = $_SESSION['id'] ?? null;

    $tugas       = $this->tugasModel->getById($id);
    $pengumpulan = $this->pengumpulanModel->getBySiswaAndTugas($id, $siswa_id);

    return [
        'tugas'       => $tugas,
        'pengumpulan' => $pengumpulan
    ];
}

public function nilai()
{
    $siswa_id = $_SESSION['id'] ?? null;

    $filter_mapel  = $_GET['mapel_id'] ?? '';
    $filter_status = $_GET['status'] ?? '';
    $filter_awal   = $_GET['tanggal_awal'] ?? '';
    $filter_akhir  = $_GET['tanggal_akhir'] ?? '';

    $mapelList = [];
    $query_mapel = mysqli_query($this->koneksi, "SELECT id, nama_mapel FROM mapel ORDER BY nama_mapel ASC");
    if ($query_mapel) {
        while ($m = mysqli_fetch_assoc($query_mapel)) {
            $mapelList[] = $m;
        }
    }

    return [
        'riwayat' => $this->pengumpulanModel->getRiwayatBySiswa(
            $siswa_id, $filter_mapel, $filter_status, $filter_awal, $filter_akhir
        ),
        'mapelList'     => $mapelList,
        'filter_mapel'  => $filter_mapel,
        'filter_status' => $filter_status,
        'filter_awal'   => $filter_awal,
        'filter_akhir'  => $filter_akhir,
    ];
}

   public function uploadTugas()
{
    $siswa_id = $_SESSION['id'] ?? null;

if (isset($_POST['upload'])) {

  $tugas_id = (int) ($_POST['tugas_id'] ?? $_GET['id'] ?? 0);
    $catatan  = $_POST['catatan'] ?? '';

    if ($tugas_id <= 0) {
        header("Location: upload_tugas.php?error=pilih_tugas_dulu");
        exit;
    }

        $file_jawaban = '';

     if (!empty($_FILES['file']['name'])) {
    $namaFile = $_FILES['file']['name'];
    $tmpFile  = $_FILES['file']['tmp_name'];

    $folderTujuan = __DIR__ . '/../../uploads/jawaban/';

    if (!is_dir($folderTujuan)) {
        mkdir($folderTujuan, 0777, true);
    }

    $berhasil = move_uploaded_file($tmpFile, $folderTujuan . $namaFile);

    if ($berhasil) {
        $file_jawaban = $namaFile;
    } else {
        die('Upload file gagal. Cek folder uploads/jawaban ada dan bisa ditulis.');
    }
}

        $this->pengumpulanModel->simpan(
            $tugas_id,
            $siswa_id,
            $catatan,
            $file_jawaban
        );

        header("Location: tugas_saya.php?berhasil=1");
        exit;
    }

    return [
        'tugasList' => $this->tugasModel->getAll()
    ];
}
}
