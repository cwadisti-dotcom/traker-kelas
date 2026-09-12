<?php

class TugasModel
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }

    public function getAll()
    {
        return mysqli_query(
            $this->koneksi,
            "SELECT tugas.*, mapel.nama_mapel
             FROM tugas
             LEFT JOIN mapel ON tugas.mapel_id = mapel.id
             ORDER BY tugas.deadline ASC"
        );
    }

    public function getTotal()
    {
        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total FROM tugas"
        );

        return mysqli_fetch_assoc($query)['total'];
    }

    public function getDashboardGuru()
    {
        return mysqli_query(
            $this->koneksi,
            "SELECT tugas.*, mapel.nama_mapel
             FROM tugas
             LEFT JOIN mapel ON tugas.mapel_id = mapel.id
             ORDER BY tugas.deadline ASC
             LIMIT 10"
        );
    }

    public function tambah(
        $nama_tugas,
        $deskripsi,
        $file_pdf,
        $deadline,
        $guru_id,
        $mapel_id
    ) {
        $guru_id  = $guru_id ? (int) $guru_id : 'NULL';
        $mapel_id = (int) $mapel_id;

        return mysqli_query(
            $this->koneksi,
            "INSERT INTO tugas
            (nama_tugas, deskripsi, file_pdf, deadline, guru_id, mapel_id, status)
            VALUES
            ('$nama_tugas', '$deskripsi', '$file_pdf', '$deadline', $guru_id, $mapel_id, 'Dalam Proses')"
        );
    }

    public function getTotalAktif()
    {
        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
            FROM tugas
            WHERE deadline >= CURDATE()"
        );

        return mysqli_fetch_assoc($query)['total'];
    }

    public function getById($id)
    {
        $id = (int) $id;

        $query = mysqli_query(
            $this->koneksi,
            "SELECT
                tugas.*,
                mapel.nama_mapel
             FROM tugas
             LEFT JOIN mapel
                ON tugas.mapel_id = mapel.id
             WHERE tugas.id='$id'"
        );

        return mysqli_fetch_assoc($query);
    }

    public function update(
        $id,
        $nama_tugas,
        $mapel_id,
        $deskripsi,
        $deadline
    ) {
        $id       = (int) $id;
        $mapel_id = (int) $mapel_id;

        return mysqli_query(
            $this->koneksi,
            "UPDATE tugas SET
            nama_tugas='$nama_tugas',
            mapel_id='$mapel_id',
            deskripsi='$deskripsi',
            deadline='$deadline'
            WHERE id='$id'"
        );
    }

    public function hapus($id)
    {
        $id = (int) $id;

        return mysqli_query(
            $this->koneksi,
            "DELETE FROM tugas WHERE id='$id'"
        );
    }

    public function getDashboardSiswa($siswa_id, $limit = 5)
    {
        $siswa_id = (int) $siswa_id;
        $limit    = (int) $limit;

        return mysqli_query(
            $this->koneksi,
            "SELECT
                tugas.*,
                mapel.nama_mapel,
                COALESCE(pengumpulan_tugas.status, 'Belum Upload') AS status_siswa
             FROM tugas
             LEFT JOIN mapel
                ON tugas.mapel_id = mapel.id
             LEFT JOIN pengumpulan_tugas
                ON tugas.id = pengumpulan_tugas.tugas_id
                AND pengumpulan_tugas.siswa_id = '$siswa_id'
             ORDER BY tugas.deadline ASC
             LIMIT $limit"
        );
    }

    public function getBelumDikumpulkan($siswa_id)
    {
        $siswa_id = (int) $siswa_id;

        return mysqli_query(
            $this->koneksi,
            "SELECT tugas.*, mapel.nama_mapel
             FROM tugas
             LEFT JOIN mapel
                ON tugas.mapel_id = mapel.id
             WHERE tugas.id NOT IN (
                SELECT tugas_id
                FROM pengumpulan_tugas
                WHERE siswa_id = '$siswa_id'
             )
             ORDER BY tugas.deadline ASC"
        );
    }

    public function getAllWithStatusSiswa($siswa_id)
    {
        $siswa_id = (int) $siswa_id;

        return mysqli_query(
            $this->koneksi,
            "SELECT
                tugas.*,
                mapel.nama_mapel,
                COALESCE(pengumpulan_tugas.status, 'Belum Dikerjakan') AS status_siswa
             FROM tugas
             LEFT JOIN mapel
                ON tugas.mapel_id = mapel.id
             LEFT JOIN pengumpulan_tugas
                ON tugas.id = pengumpulan_tugas.tugas_id
                AND pengumpulan_tugas.siswa_id = '$siswa_id'
             ORDER BY tugas.deadline ASC"
        );
    }

    public function getTotalTerlambat($siswa_id)
    {
        $siswa_id = (int) $siswa_id;

        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
             FROM tugas
             LEFT JOIN pengumpulan_tugas
                ON tugas.id = pengumpulan_tugas.tugas_id
                AND pengumpulan_tugas.siswa_id = '$siswa_id'
             WHERE tugas.deadline < CURDATE()
             AND pengumpulan_tugas.id IS NULL"
        );

        return mysqli_fetch_assoc($query)['total'];
    }

    public function rekamView($tugas_id, $siswa_id)
    {
        $tugas_id = (int) $tugas_id;
        $siswa_id = (int) $siswa_id;

        if ($tugas_id > 0 && $siswa_id > 0) {
            $stmt = $this->koneksi->prepare("INSERT IGNORE INTO tugas_views (tugas_id, user_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $tugas_id, $siswa_id);
            return $stmt->execute();
        }

        return false;
    }

    public function getViewers($tugas_id)
    {
        $tugas_id = (int) $tugas_id;

        $query = "SELECT users.username, tugas_views.dibuka_pada 
                  FROM tugas_views 
                  JOIN users ON tugas_views.user_id = users.id 
                  WHERE tugas_views.tugas_id = '$tugas_id' 
                  ORDER BY tugas_views.dibuka_pada DESC";

        return mysqli_query($this->koneksi, $query);
    }
}