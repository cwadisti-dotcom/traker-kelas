<?php

class PengumpulanModel
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }

    public function getTotalUpload()
    {
    $query = mysqli_query(
        $this->koneksi,
        "SELECT COUNT(*) as total
         FROM pengumpulan_tugas
         WHERE file_jawaban IS NOT NULL
         AND file_jawaban != ''"
    );

    return mysqli_fetch_assoc($query)['total'];
    }

    public function getTotalDinilai()
    {
        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
             FROM pengumpulan_tugas
             WHERE nilai IS NOT NULL
             AND nilai > 0"
        );

        $data = mysqli_fetch_assoc($query);

        return $data['total'];
    }

    public function getMonitoring()
    {
        return mysqli_query(
            $this->koneksi,
            "SELECT
                pengumpulan_tugas.*,
                tugas.nama_tugas,
                users.username AS siswa
            FROM pengumpulan_tugas
            LEFT JOIN tugas
            ON pengumpulan_tugas.tugas_id = tugas.id
            LEFT JOIN users
            ON pengumpulan_tugas.siswa_id = users.id
            ORDER BY pengumpulan_tugas.tanggal_upload DESC"
        );
    }

    public function getTotalBelumUpload()
    {
        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
            FROM pengumpulan_tugas
            WHERE file_jawaban IS NULL
            OR file_jawaban=''"
        );

        return mysqli_fetch_assoc($query)['total'];
    }

    public function getTotal()
    {
        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
             FROM pengumpulan_tugas"
        );

        return mysqli_fetch_assoc($query)['total'];
    }

    public function getTotalBelumDinilai()
    {
        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
             FROM pengumpulan_tugas
             WHERE nilai = 0
             OR nilai IS NULL"
        );

        return mysqli_fetch_assoc($query)['total'];
    }

    public function getAllWithTugas()
    {
        return mysqli_query(
            $this->koneksi,
            "SELECT
                pengumpulan_tugas.*,
                tugas.nama_tugas,
                mapel.nama_mapel AS mapel,
                users.username AS siswa
            FROM pengumpulan_tugas
            LEFT JOIN tugas
            ON pengumpulan_tugas.tugas_id = tugas.id
            LEFT JOIN mapel
            ON tugas.mapel_id = mapel.id
            LEFT JOIN users
            ON pengumpulan_tugas.siswa_id = users.id
            ORDER BY pengumpulan_tugas.tanggal_upload DESC"
        );
    }

    public function updateNilai($id, $nilai)
    {
        $id = (int) $id;
        $nilai = (int) $nilai;

        return mysqli_query(
            $this->koneksi,
            "UPDATE pengumpulan_tugas
            SET nilai='$nilai', status='Sudah Dinilai'
            WHERE id='$id'"
        );
    }

    public function getTotalSelesaiBySiswa($siswa_id)
    {
        $siswa_id = (int) $siswa_id;

        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
             FROM pengumpulan_tugas
             WHERE siswa_id = '$siswa_id'
             AND status = 'Sudah Dinilai'"
        );

        return mysqli_fetch_assoc($query)['total'];
    }

   public function getRiwayatBySiswa($siswa_id, $mapel_id = '', $status = '', $tanggal_awal = '', $tanggal_akhir = '')
{
    $siswa_id = (int) $siswa_id;

    $sql = "SELECT
                pengumpulan_tugas.nilai,
                pengumpulan_tugas.status,
                pengumpulan_tugas.tanggal_upload,
                tugas.nama_tugas,
                mapel.nama_mapel
             FROM pengumpulan_tugas
             JOIN tugas
                ON tugas.id = pengumpulan_tugas.tugas_id
             LEFT JOIN mapel
                ON tugas.mapel_id = mapel.id
             WHERE pengumpulan_tugas.siswa_id = '$siswa_id'";

    if ($mapel_id !== '') {
        $mapel_id = (int) $mapel_id;
        $sql .= " AND tugas.mapel_id = '$mapel_id'";
    }

    if ($status !== '') {
        $status = mysqli_real_escape_string($this->koneksi, $status);
        $sql .= " AND pengumpulan_tugas.status = '$status'";
    }

    if ($tanggal_awal !== '') {
        $tanggal_awal = mysqli_real_escape_string($this->koneksi, $tanggal_awal);
        $sql .= " AND DATE(pengumpulan_tugas.tanggal_upload) >= '$tanggal_awal'";
    }

    if ($tanggal_akhir !== '') {
        $tanggal_akhir = mysqli_real_escape_string($this->koneksi, $tanggal_akhir);
        $sql .= " AND DATE(pengumpulan_tugas.tanggal_upload) <= '$tanggal_akhir'";
    }

    $sql .= " ORDER BY pengumpulan_tugas.id DESC";

    return mysqli_query($this->koneksi, $sql);
}

    public function simpan($tugas_id, $siswa_id, $catatan, $file_jawaban)
    {
        $tugas_id    = (int) $tugas_id;
        $siswa_id    = (int) $siswa_id;
        $catatan_esc = mysqli_real_escape_string($this->koneksi, $catatan);
        $file_esc    = mysqli_real_escape_string($this->koneksi, $file_jawaban);

        return mysqli_query(
            $this->koneksi,
            "INSERT INTO pengumpulan_tugas
            (tugas_id, siswa_id, jawaban, file_jawaban, status)
            VALUES
            ('$tugas_id', '$siswa_id', '$catatan_esc', '$file_esc', 'Belum Dinilai')"
        );
    }
    public function getBySiswaAndTugas($tugas_id, $siswa_id)
{
    $tugas_id = (int) $tugas_id;
    $siswa_id = (int) $siswa_id;

    $query = mysqli_query(
        $this->koneksi,
        "SELECT * FROM pengumpulan_tugas
         WHERE tugas_id = '$tugas_id'
         AND siswa_id = '$siswa_id'
         LIMIT 1"
    );

    return mysqli_fetch_assoc($query);
}
}
