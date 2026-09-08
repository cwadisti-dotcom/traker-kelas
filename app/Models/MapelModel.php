<?php

class MapelModel
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }

    public function getAll()
    {
        $result = mysqli_query(
            $this->koneksi,
            "SELECT * FROM mapel ORDER BY nama_mapel ASC"
        );

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function tambah($nama_mapel)
    {
        return mysqli_query(
            $this->koneksi,
            "INSERT INTO mapel (nama_mapel) VALUES ('$nama_mapel')"
        );
    }

    public function update($id, $nama_mapel)
    {
        $id = (int) $id;

        return mysqli_query(
            $this->koneksi,
            "UPDATE mapel SET nama_mapel='$nama_mapel' WHERE id='$id'"
        );
    }

    public function hapus($id)
    {
        $id = (int) $id;

        return mysqli_query(
            $this->koneksi,
            "DELETE FROM mapel WHERE id='$id'"
        );
    }
}