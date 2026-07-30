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
            "SELECT * FROM tugas
             ORDER BY deadline ASC"
        );
    }

    public function getTotal()
    {
        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
             FROM tugas"
        );

        $data = mysqli_fetch_assoc($query);

        return $data['total'];
    }

    public function getDashboardGuru()
    {
        return mysqli_query(
            $this->koneksi,
            "SELECT *
             FROM tugas
             ORDER BY deadline ASC
             LIMIT 10"
        );
    }

    public function tambah(
        $nama_tugas,
        $deskripsi,
        $file_pdf,
        $deadline,
        $guru,
        $mapel
    )
    {
        return mysqli_query(
            $this->koneksi,
            "INSERT INTO tugas
            (
                nama_tugas,
                deskripsi,
                file_pdf,
                deadline,
                guru,
                mapel,
                progress,
                status
            )
            VALUES
            (
                '$nama_tugas',
                '$deskripsi',
                '$file_pdf',
                '$deadline',
                '$guru',
                '$mapel',
                0,
                'Dalam Proses'
            )"
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
        $query = mysqli_query(
            $this->koneksi,
            "SELECT * FROM tugas WHERE id='$id'"
        );

        return mysqli_fetch_assoc($query);
    }

    public function update(
        $id,
        $nama_tugas,
        $mapel,
        $deskripsi,
        $deadline
    )
    {
        return mysqli_query(
            $this->koneksi,
            "UPDATE tugas SET
            nama_tugas='$nama_tugas',
            mapel='$mapel',
            deskripsi='$deskripsi',
            deadline='$deadline'
            WHERE id='$id'"
        );
    }

    public function hapus($id)
    {
        return mysqli_query(
            $this->koneksi,
            "DELETE FROM tugas WHERE id='$id'"
        );
    }
}