<?php

class MateriModel
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
            "SELECT materi.*, mapel.nama_mapel
             FROM materi
             LEFT JOIN mapel ON materi.mapel_id = mapel.id
             ORDER BY materi.created_at DESC"
        );
    }

    public function getById($id)
    {
        $id = (int) $id;

        $query = mysqli_query(
            $this->koneksi,
            "SELECT * FROM materi WHERE id='$id'"
        );

        return mysqli_fetch_assoc($query);
    }

    public function tambah($judul, $deskripsi, $file_materi, $mapel_id, $guru_id)
    {
        $guru_id  = $guru_id ? (int) $guru_id : 'NULL';
        $mapel_id = (int) $mapel_id;

        return mysqli_query(
            $this->koneksi,
            "INSERT INTO materi
            (judul, deskripsi, file_materi, mapel_id, guru_id)
            VALUES
            ('$judul', '$deskripsi', '$file_materi', $mapel_id, $guru_id)"
        );
    }

    public function update($id, $judul, $mapel_id, $deskripsi, $file_materi = null)
    {
        $id       = (int) $id;
        $mapel_id = (int) $mapel_id;

        if ($file_materi) {
            return mysqli_query(
                $this->koneksi,
                "UPDATE materi SET
                judul='$judul',
                mapel_id='$mapel_id',
                deskripsi='$deskripsi',
                file_materi='$file_materi'
                WHERE id='$id'"
            );
        }

        return mysqli_query(
            $this->koneksi,
            "UPDATE materi SET
            judul='$judul',
            mapel_id='$mapel_id',
            deskripsi='$deskripsi'
            WHERE id='$id'"
        );
    }

    public function hapus($id)
    {
        $id = (int) $id;

        return mysqli_query(
            $this->koneksi,
            "DELETE FROM materi WHERE id='$id'"
        );
    }
}