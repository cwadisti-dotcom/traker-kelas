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
            "SELECT materi.*, mapel.nama_mapel
             FROM materi
             LEFT JOIN mapel ON materi.mapel_id = mapel.id
             WHERE materi.id='$id'"
        );

        return mysqli_fetch_assoc($query);
    }

    public function getByMapel($mapel_id)
    {
        $mapel_id = (int) $mapel_id;

        return mysqli_query(
            $this->koneksi,
            "SELECT materi.*, mapel.nama_mapel
             FROM materi
             LEFT JOIN mapel ON materi.mapel_id = mapel.id
             WHERE materi.mapel_id='$mapel_id'
             ORDER BY materi.created_at DESC"
        );
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

    public function rekamView($materi_id, $siswa_id)
    {
        $materi_id = (int) $materi_id;
        $siswa_id  = (int) $siswa_id;

        if ($materi_id > 0 && $siswa_id > 0) {
            $stmt = $this->koneksi->prepare("INSERT IGNORE INTO materi_views (materi_id, user_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $materi_id, $siswa_id);
            return $stmt->execute();
        }

        return false;
    }

    public function getViewers($materi_id)
    {
        $materi_id = (int) $materi_id;

        $query = "SELECT users.username, materi_views.dibuka_pada 
                  FROM materi_views 
                  JOIN users ON materi_views.user_id = users.id 
                  WHERE materi_views.materi_id = '$materi_id' 
                  ORDER BY materi_views.dibuka_pada DESC";

        return mysqli_query($this->koneksi, $query);
    }
}