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
                tugas.nama_tugas
            FROM pengumpulan_tugas
            LEFT JOIN tugas
            ON pengumpulan_tugas.tugas_id = tugas.id
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
}