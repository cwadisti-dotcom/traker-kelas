<?php
class LaporanModel
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }

    public function getRekapNilai($mapel_id = null, $status = null, $tanggal_awal = null, $tanggal_akhir = null)
    {
        $query = "SELECT 
                    u.username AS nama_siswa,
                    m.nama_mapel,
                    t.nama_tugas,
                    pt.nilai,
                    pt.status,
                    pt.tanggal_upload
                  FROM pengumpulan_tugas pt
                  JOIN tugas t ON pt.tugas_id = t.id
                  JOIN mapel m ON t.mapel_id = m.id
                  JOIN users u ON pt.siswa_id = u.id
                  WHERE 1=1";

        $params = [];
        $types = "";

        if (!empty($mapel_id)) {
            $query .= " AND m.id = ?";
            $params[] = $mapel_id;
            $types  .= "i";
        }

        if (!empty($status)) {
            $query .= " AND pt.status = ?";
            $params[] = $status;
            $types  .= "s";
        }

        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $query .= " AND DATE(pt.tanggal_upload) BETWEEN ? AND ?";
            $params[] = $tanggal_awal;
            $params[] = $tanggal_akhir;
            $types  .= "ss";
        }

        $query .= " ORDER BY u.username ASC, m.nama_mapel ASC";

        $stmt = mysqli_prepare($this->koneksi, $query);

        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }
}