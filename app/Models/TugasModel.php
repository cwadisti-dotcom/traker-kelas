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
    )
    {
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
            "SELECT * FROM tugas WHERE id='$id'"
        );

        return mysqli_fetch_assoc($query);
    }

    public function update(
        $id,
        $nama_tugas,
        $mapel_id,
        $deskripsi,
        $deadline
    )
    {
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
}