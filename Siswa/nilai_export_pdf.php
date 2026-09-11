<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../config/koneksi.php';
include __DIR__ . '/../app/Models/PengumpulanModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$siswa_id = $_SESSION['id'] ?? null;

if (!$siswa_id) {
    die('Sesi login tidak ditemukan.');
}

$pengumpulanModel = new PengumpulanModel($koneksi);

$mapel_id      = $_GET['mapel_id'] ?? '';
$status        = $_GET['status'] ?? '';
$tanggal_awal  = $_GET['tanggal_awal'] ?? '';
$tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

$riwayat = $pengumpulanModel->getRiwayatBySiswa(
    $siswa_id, $mapel_id, $status, $tanggal_awal, $tanggal_akhir
);

$rows = [];
while ($data = mysqli_fetch_assoc($riwayat)) {
    $rows[] = $data;
}

// Bangun HTML tabel untuk dijadikan PDF
$html = '
<html>
<head>
<style>
    body { font-family: sans-serif; font-size: 12px; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
    th { background: #f0f0f0; }
</style>
</head>
<body>
<h2>Nilai Saya</h2>
<table>
    <thead>
        <tr>
            <th>Mapel</th>
            <th>Nama Tugas</th>
            <th>Nilai</th>
            <th>Status</th>
            <th>Tanggal Upload</th>
        </tr>
    </thead>
    <tbody>';

if (count($rows) > 0) {
    foreach ($rows as $data) {
        $html .= '<tr>
            <td>' . htmlspecialchars($data['nama_mapel'] ?? '-') . '</td>
            <td>' . htmlspecialchars($data['nama_tugas']) . '</td>
            <td>' . htmlspecialchars($data['nilai'] > 0 ? $data['nilai'] : '-') . '</td>
            <td>' . htmlspecialchars($data['status']) . '</td>
            <td>' . htmlspecialchars($data['tanggal_upload'] ?? '-') . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="5" style="text-align:center;">Belum ada data nilai.</td></tr>';
}

$html .= '</tbody></table></body></html>';

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$filename = 'Nilai_Saya_' . date('Ymd_His') . '.pdf';

$dompdf->stream($filename, ['Attachment' => true]);
exit;